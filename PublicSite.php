<?php

namespace Kodbazis;

use DateTime;
use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Request;
use mysqli;
use Twig\Environment;
use Kodbazis\Mailer\Mailer;
use Kodbazis\Generated\Paging\Pager;
use Kodbazis\Generated\Post\Listing\ListController;
use Kodbazis\Generated\Repository\Post\SqlLister;
use Kodbazis\Generated\Repository\Subscriber\SqlSaver as SubscriberSaver;
use Kodbazis\Generated\Repository\Message\SqlSaver as MessageSaver;
use Kodbazis\Generated\Repository\Message\SqlPatcher as MessagePatcher;
use Kodbazis\Generated\Repository\Message\SqlLister as MessageLister;
use Kodbazis\Generated\Repository\Subscriber\SqlLister as SubscriberLister;
use Kodbazis\Generated\Repository\Subscriber\SqlPatcher as SubscriberPatcher;
use Kodbazis\Generated\Repository\Embeddable\SqlByIdGetter;
use Kodbazis\Generated\Repository\Course\SqlLister as CourseLister;
use Kodbazis\Generated\Repository\Coupon\SqlLister as CouponLister;
use Kodbazis\Generated\Repository\Coupon\SqlPatcher as CouponPatcher;
use Kodbazis\Generated\Repository\SubscriberCourse\SqlLister as SubscriberCourseLister;
use Kodbazis\Generated\Repository\SubscriberCourse\SqlSaver as SubscriberCourseSaver;
use Kodbazis\Generated\Repository\SubscriberCourse\SqlDeleter as SubscriberCourseDeleter;
use Kodbazis\Generated\Repository\SubscriberCourse\SqlByIdGetter as SubscriberCourseById;
use Kodbazis\Generated\Repository\Episode\SqlLister as EpisodeLister;
use Kodbazis\Generated\Repository\Quote\SqlLister as QuoteLister;
use Kodbazis\Generated\Repository\Spec\SqlLister as SpecLister;
use Kodbazis\Episodes;
use Kodbazis\Generated\Coupon\Patch\PatchedCoupon;
use Kodbazis\Generated\Listing\Clause;
use Kodbazis\Generated\Listing\Filter;
use Kodbazis\Generated\Listing\OrderBy;
use Kodbazis\Generated\Listing\Query;
use Kodbazis\Generated\Message\Patch\PatchedMessage;
use Kodbazis\Generated\Message\Save\NewMessage;
use Kodbazis\Generated\Subscriber\Patch\PatchedSubscriber;
use Kodbazis\Generated\Subscriber\Save\NewSubscriber;
use Kodbazis\Generated\SubscriberCourse\Save\NewSubscriberCourse;
use SzamlaAgent\Document\Receipt\Receipt;
use Kodbazis\Generated\Repository\Embeddable\SqlLister as EmbeddableLister;
use Kodbazis\Generated\Route\Comment\CommentSaver;

class PublicSite
{

    public static function initSubscriberSession($conn)
    {
        return function (Request $request) use ($conn) {
            if (!isset($_COOKIE[session_name()])) {
                return $request;
            }

            if (!isset($_SESSION)) {
                session_start();
            }

            $subscriber = null;
            if (!isset($_SESSION['subscriberId'])) {
                return $request;
            }

            $byId = (new SubscriberLister($conn))->list(Router::where('id', 'eq', $_SESSION['subscriberId']));
            if (!$byId->getCount()) {
                return $request;
            }

            $subscriber = $byId->getEntities()[0];
            if (!$subscriber->getIsVerified()) {
                return $request;
            }
            $request->vars['subscriber'] = $subscriber;
            return $request;
        };
    }

    private static function organizationStructuredData()
    {
        return json_encode([
            "@context" => "https://schema.org",
            "@type" => "Organization",
            "url" => Router::siteUrl(),
            "logo" => Router::siteUrl() . "/public/images/logo-dark.png"
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public static function getRoutes(Pipeline $r, mysqli $conn, Environment $twig)
    {

        $initSubscriberSession = self::initSubscriberSession($conn);

        $r->get('/', self::initSubscriberSession($conn), function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');

            echo $twig->render('wrapper.twig', [
                'content' => $twig->render('home.twig', [
                    'content' => $twig->render('introduction.twig', [
                        "items" => getCourseItems($conn),
                    ]),
                ]),
                'description' => 'Kódbázis | Programozás egyszerűen elmagyarázva',
                'subscriberLabel' =>  getNick($request->vars),
                'structuredData' => self::organizationStructuredData(),
                'scripts' => [
                    ['path' => 'js/jquery.js'],
                    ['path' => 'js/application.js'],
                ],
                'styles' => [
                    ['path' => 'css/login.css'],
                    ['path' => 'css/promo.css'],
                    ['path' => 'css/fonts/fontawesome/css/fontawesome-all.css'],
                ],
            ]);
        });

        $r->post('/api/comments', function (Request $request) use ($conn, $twig) {
            (new MessageSaver($conn))->Save(new NewMessage(
                $_SERVER['SMTP_SENDER_EMAIL'],
                'Új kérdés érkezett',
                "EmbeddableId: " . $request->body['embeddableId'],
                "notSent",
                0,
                null,
                time()
            ));

            echo (new CommentSaver)->getRoute($request);
        });

        $r->post('/api/unsubscribe/{subscriberId}', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            $byId = (new SubscriberLister($conn))->list(Router::where('id', 'eq', $request->vars['subscriberId']));

            $parsed = parse_url($_SERVER['HTTP_REFERER']);
            $requestUri = $parsed['path'];

            if (!$byId->getCount()) {
                $params = [
                    'error=invalidCredentials',
                ];
                header('Location: ' .  $requestUri . Router::mergeQueries($_SERVER['HTTP_REFERER'], $params));
                return;
            }

            $subscriber = $byId->getEntities()[0];

            if (!$subscriber->getIsVerified()) {
                $params = [
                    'error=notVerified',
                ];
                header('Location: ' .  $requestUri . Router::mergeQueries($_SERVER['HTTP_REFERER'], $params));
                return;
            }

            if (!password_verify($request->body['password'], $subscriber->getPassword())) {
                $params = [
                    'error=invalidCredentials',
                ];

                header('Location: ' .  $requestUri . Router::mergeQueries($_SERVER['HTTP_REFERER'], $params));
                return;
            }

            (new SubscriberPatcher($conn))->patch(
                $subscriber->getId(),
                new PatchedSubscriber(null, null, null, null, 1)
            );

            $params = [
                'isSuccess=1',
            ];
            header('Location: ' .  $requestUri . Router::mergeQueries($_SERVER['HTTP_REFERER'], $params));
        });

        $r->get('/leiratkozas/{subscriberId}', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');
            if (!isset($request->vars['subscriberId'])) {
                header('Location: /');
                return;
            }
            echo $twig->render('wrapper.twig', [
                "title" => "Leiratkozás",
                'content' => $twig->render('unsubscribe.twig', [
                    'isError' => isset($_GET['error']),
                    'subscriberId' => $request->vars['subscriberId'],
                    'isSuccess' => isset($_GET['isSuccess']),
                    'referer' => $_SERVER['HTTP_REFERER'] ?? '',
                ]),
                'subscriberLabel' =>  getNick($request->vars),
                'styles' => [
                    ['path' => 'css/login.css']
                ],
                'noIndex' => true,
            ]);
        });

        $r->get('/elfelejtett-jelszo', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');
            if (isset($request->vars['subscriber'])) {
                header('Location: /');
                return;
            }

            echo $twig->render('wrapper.twig', [
                "title" => "Elfelejtett jelszó",
                'content' => $twig->render('forgot-password.twig', [
                    'isError' => isset($_GET['isError']),
                    'emailSent' => isset($_GET['emailSent']),
                    'referer' => $_SERVER['HTTP_REFERER'] ?? '',
                ]),
                'subscriberLabel' =>  getNick($request->vars),
                'styles' => [
                    ['path' => 'css/login.css'],
                    ['path' => 'css/fonts/fontawesome/css/fontawesome-all.css'],
                ],
                'noIndex' => true,
            ]);
        });

        $r->get('/api/forgot-password', function (Request $request) {
            header('Location: /elfelejtett-jelszo?isError=1');
        });

        $r->post('/api/forgot-password', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');
            if (isset($request->vars['subscriber'])) {
                header('Location: /');
                return;
            }

            $byEmail = (new SubscriberLister($conn))->list(Router::where('email', 'eq', $request->body['email']));

            if ($byEmail->getCount() === 0) {
                header('Location: /elfelejtett-jelszo?isError=1');
                return;
            }
            header('Location: /elfelejtett-jelszo?emailSent=1');

            $subscriber = $byEmail->getEntities()[0];
            $token = uniqid();

            (new SubscriberPatcher($conn))->patch(
                $subscriber->getId(),
                new PatchedSubscriber(null, null, 1, $token, null)
            );

            $body = $twig->render('forgot-password-email.twig', [
                'email' => $subscriber->getEmail(),
                'link' => Router::siteUrl() . "/jelszo-megvaltoztatasa/" . $token . "?referer=" . $_GET['referer'],
            ]);

            (new MessageSaver($conn))->Save(new NewMessage(
                $subscriber->getEmail(),
                'Jelszó megváltoztatása',
                $body,
                "notSent",
                0,
                null,
                time()
            ));
        });

        $r->post("/api/send-mails", function (Request $request) use ($conn, $twig) {
            header('Content-Type: application/json');
            if (($request->body['key'] ?? 0) !== ($_SERVER['MASTER_PW'] ?? 1)) {
                http_response_code(401);
                echo json_encode(['error' => 'unauthorized']);
                return;
            }

            $messages = (new MessageLister($conn))->list(new Query(
                1000,
                0,
                new Filter(
                    'and',
                    new Clause('lt', 'numberOfAttempts', 10),
                    new Clause('eq', 'status', "notSent"),
                ),
                new OrderBy('createdAt', 'asc')
            ));

            foreach ($messages->getEntities() as $message) {
                (new MessagePatcher($conn))->patch($message->getId(), new PatchedMessage(
                    "sending",
                    $message->getNumberOfAttempts() + 1,
                    null,
                ));
                $isSent = (new Mailer())->sendMail($message->getEmail(), $message->getSubject(), $message->getBody());
                if ($isSent) {
                    (new MessagePatcher($conn))->patch($message->getId(), new PatchedMessage(
                        "sent",
                        null,
                        time()
                    ));
                } else {
                    (new MessagePatcher($conn))->patch($message->getId(), new PatchedMessage(
                        "notSent",
                        null,
                        null,
                    ));
                }
            }
        });

        $r->get('/jelszo-megvaltoztatasa/{token}', function (Request $request) use ($conn, $twig) {
            $byToken = (new SubscriberLister($conn))->list(Router::where('verificationToken', 'eq', $request->vars['token']));

            if ($byToken->getCount() === 0) {
                header('Location: /');
                return;
            }
            echo $twig->render('wrapper.twig', [
                'content' => $twig->render('create-new-password.twig', [
                    'token' => $request->vars['token'],
                    'referer' => $_GET['referer'] ?? '',
                ]),
                'styles' => [
                    ['path' => 'css/login.css']
                ],
            ]);
        });

        $r->post('/api/patch-subscriber-password', function (Request $request) use ($conn) {
            $byToken = (new SubscriberLister($conn))->list(Router::where('verificationToken', 'eq', $request->body['token']));

            if ($byToken->getCount() === 0) {
                header('Location: /');
                return;
            }

            $subscriber = $byToken->getEntities()[0];

            if (!$subscriber->getIsVerified()) {
                header('Location: /');
                return;
            }

            $password = password_hash($request->body['password'], PASSWORD_DEFAULT);
            $byToken = (new SubscriberPatcher($conn))->patch($subscriber->getId(), new PatchedSubscriber(null, $password, 1, '', null));
            if ($_GET['referer']) {
                $parsedUrl = parse_url($_GET['referer']);
                $params = ['isPasswordModificationSuccess=1'];
                header('Location: ' .  $parsedUrl['path'] . Router::mergeQueries($_GET['referer'], $params));
                return;
            }
            header('Location: /bejelentkezes?isPasswordModificationSuccess=1');
        });

        $r->get('/jelszo-modositasa-sikeres', function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');
            echo $twig->render('wrapper.twig', [
                'content' => $twig->render('subscriber-password-modification-success.twig', []),
            ]);
        });

        $r->get('/bejelentkezes', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');
            echo $twig->render('wrapper.twig', [
                'structuredData' => self::organizationStructuredData(),
                'subscriberLabel' =>  getNick($request->vars),
                'noIndex' => true,
                'content' => $twig->render('subscriber-login.twig', [
                    'subscriberLabel' =>  getNick($request->vars),
                    'isLoggedIn' => isset($_SESSION['subscriberId']),
                    'error' => $_GET['error'] ?? '',
                    'loginSuccess' => isset($_GET['loginSuccess']),
                    'isPasswordModificationSuccess' => isset($_GET['isPasswordModificationSuccess']),
                    'email' => $_GET['email'] ?? '',
                ]),
                'styles' => [
                    ['path' => 'css/login.css'],
                    ['path' => 'css/fonts/fontawesome/css/fontawesome-all.css'],
                ],
            ]);
        });

        $r->get('/webfejleszto-online-kurzusok', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');

            echo $twig->render('wrapper.twig', [
                'structuredData' => self::organizationStructuredData(),
                'subscriberLabel' =>  getNick($request->vars),
                'title' => "Webfejlesztő online kurzusok",
                'description' => "Válj full stack fejlesztővé, kezdőknek szóló online kurzusok segítségével",
                'content' => $twig->render('introduction-wrapper.twig', [
                    'content' => $twig->render('introduction.twig', [
                        "items" => getCourseItems($conn),
                    ])
                ]),
                'styles' => [
                    ['path' => 'css/login.css'],
                    ['path' => 'css/promo.css'],
                    ['path' => 'css/fonts/fontawesome/css/fontawesome-all.css'],
                ],
            ]);
        });

        $r->get('/legyel-te-is-tartalomkeszito', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');

            echo $twig->render('wrapper.twig', [
                'structuredData' => self::organizationStructuredData(),
                'subscriberLabel' =>  getNick($request->vars),
                'title' => "Legyél Te is tartalomkészítő a Kódbázison!",
                'description' => "Készítsd el saját online kurzusod és értékesítsd a Kódbázis felületén keresztül!",
                'content' => $twig->render('platform-invitation.html'),
                'styles' => [
                    ['path' => 'css/promo.css'],
                    ['path' => 'fontawesome/css/all.css'],
                ],
                'ogTags' => [
                    [
                        'property' => 'og:url',
                        'content' => Router::siteUrl() . parse_url(Router::siteUrl() . $_SERVER['REQUEST_URI'])['path'],
                    ],
                    [
                        'property' => 'og:type',
                        'content' => 'article',
                    ],
                    [
                        'property' => 'og:title',
                        'content' => 'Legyél Te is tartalomkészítő a Kódbázison!',
                    ],
                    [
                        'property' => 'og:image',
                        'content' => Router::siteUrl() . '/public/images/invitation.webp',
                    ],
                    [
                        'property' => 'og:description',
                        'content' => 'Készítsd el saját online kurzusod és értékesítsd a Kódbázis felületén keresztül!',
                    ],
                    [
                        'property' => 'fb:app_id',
                        'content' => '705894336804251',
                    ],
                ]
            ]);
        });

        $r->get('/beagyazhato-segedletek', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');

            $embeddables = Embeddables::getEmbeddables([45], $conn);

            $apps = array_filter($embeddables, fn ($em) => $em->getType() === 'application');

            echo $twig->render('wrapper.twig', [
                'structuredData' => self::organizationStructuredData(),
                'subscriberLabel' =>  getNick($request->vars),
                'title' => "Beágyazható segédletek",
                'description' => "Beágyazható segédletek a Kódbázison!",
                'content' => $twig->render('embeddables-preview.twig', [
                    "codeAssistant" => Embeddables::contentWithEmbeddables($conn, $twig, "{{80}}"),
                    "app" => Embeddables::contentWithEmbeddables($conn, $twig, "{{52}}"),
                    "codeAssistantGif" => Embeddables::contentWithEmbeddables($conn, $twig, "{{15}}"),
                    "gif" => Embeddables::contentWithEmbeddables($conn, $twig, "{{9}}"),
                ]),
                'styles' => [
                    ['path' => 'css/promo.css'],
                    ...Embeddables::getKodsegedStyles(),
                    ...Embeddables::getAppStyles($apps),
                ],
                'scripts' => [
                    ...Embeddables::getKodsegedScripts(),
                    ...Embeddables::getAppScripts($apps),
                ],
            ]);
        });

        $r->get('/feliratkozas', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');
            echo $twig->render('wrapper.twig', [
                'structuredData' => self::organizationStructuredData(),
                'subscriberLabel' =>  getNick($request->vars),
                'noIndex' => true,
                'content' => $twig->render('subscriber-registration.twig', [
                    'isLoggedIn' => isset($_SESSION['subscriberId']),
                    'registrationSuccessful' => isset($_GET['registrationSuccessful']),
                    'registrationEmailSent' => isset($_GET['registrationEmailSent']),
                    'error' => $_GET['error'] ?? '',
                    'subscriberLabel' =>  getNick($request->vars),
                    'email' => $_GET['email'] ?? '',
                ]),
                'styles' => [
                    ['path' => 'css/login.css']
                ],
            ]);
        });

        $r->get('/sutik-kezelese', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');
            echo $twig->render('wrapper.twig', [
                'structuredData' => self::organizationStructuredData(),
                'subscriberLabel' =>  getNick($request->vars),
                'title' => "Sütik kezelése",
                'content' => $twig->render('cookie-policy.html', []),
                'noIndex' => true,
            ]);
        });

        $r->post('/api/subscriber-logout', function (Request $request) use ($conn, $twig) {
            session_start();
            $params = session_get_cookie_params();
            setcookie(session_name(), '', 0, $params['path'], $params['domain'], $params['secure'], isset($params['httponly']));
            session_destroy();

            $requestUri = parse_url($_SERVER['HTTP_REFERER'])['path'];
            header('Location: ' . $requestUri);
        });

        $r->post('/api/subscriber-login', function (Request $request) use ($conn, $twig) {
            $byEmail = (new SubscriberLister($conn))->list(Router::where('email', 'eq', $request->body['email']));

            $parsed = parse_url($_SERVER['HTTP_REFERER']);
            $requestUri = $parsed['path'];


            if (!$byEmail->getCount()) {
                $params = [
                    'error=invalidCredentials',
                    'email=' . $request->body['email'],
                ];
                header('Location: ' .  $requestUri . Router::mergeQueries($_SERVER['HTTP_REFERER'], $params));
                return;
            }

            $subscriber = $byEmail->getEntities()[0];

            if (!$subscriber->getIsVerified()) {
                $params = [
                    'error=notVerified',
                    'email=' . $request->body['email'],
                ];
                header('Location: ' .  $requestUri . Router::mergeQueries($_SERVER['HTTP_REFERER'], $params));
                return;
            }

            if (!password_verify($request->body['password'], $subscriber->getPassword())) {
                $params = [
                    'error=invalidCredentials',
                    'email=' . $request->body['email'],
                ];

                header('Location: ' .  $requestUri . Router::mergeQueries($_SERVER['HTTP_REFERER'], $params));
                return;
            }

            session_start();
            $_SESSION['subscriberId'] = $subscriber->getId();
            $params = [
                'loginSuccess=1',
            ];
            header('Location: ' .  $requestUri . Router::mergeQueries($_SERVER['HTTP_REFERER'], $params));
        });

        $r->get('/kodseged-kliens', function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');
            echo $twig->render('code-assistant-client.twig', [
                'scripts' => Embeddables::getKodsegedScripts(),
                'styles' => Embeddables::getKodsegedStyles(),
            ]);
        });

        $r->get('/prezentacio/{slug}', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');
            echo $twig->render('codesurfer.twig', ['folderName' => $request->vars['slug']]);
        });

        $r->get('/bemutatkozas', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');

            $embeddables = Embeddables::getEmbeddables([52], $conn);

            $apps = array_filter($embeddables, fn ($em) => $em->getType() === 'application');

            echo $twig->render('wrapper.twig', [
                'structuredData' => self::organizationStructuredData(),
                'subscriberLabel' =>  getNick($request->vars),
                'title' => "Bemutatkozás",
                'description' => 'Bemutatkozás',
                'content' => $twig->render('aboutus.twig', [
                    "codeAssistant" => Embeddables::contentWithEmbeddables($conn, $twig, "{{73}}"),
                    "app" => Embeddables::contentWithEmbeddables($conn, $twig, "{{52}}"),
                    "codeAssistantGif" => Embeddables::contentWithEmbeddables($conn, $twig, "{{15}}"),
                    "gif" => Embeddables::contentWithEmbeddables($conn, $twig, "{{9}}"),
                ]),
                'styles' => [
                    ['path' => 'css/promo.css'],
                    ...Embeddables::getKodsegedStyles(),
                    ...Embeddables::getAppStyles($apps),
                ],
                'scripts' => [
                    ...Embeddables::getKodsegedScripts(),
                    ...Embeddables::getAppScripts($apps),
                ],
            ]);
        });

        $r->get('/trening', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');
            echo $twig->render('wrapper.twig', [
                'structuredData' => self::organizationStructuredData(),
                'title' => "Tréning",
                'content' => $twig->render('online.html', []),
                'subscriberLabel' =>  getNick($request->vars),
                'description' => 'Személyre szabott tanítás JavaScript, React, Angular és PHP témákban.',
                'styles' => [
                    ['path' => 'css/promo.css'],
                ],
            ]);
        });
        $r->get('/php-es-mysql', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');
            echo $twig->render('wrapper.twig', [
                'structuredData' => self::organizationStructuredData(),
                'title' => "PHP és MySQL tréning",
                'content' => $twig->render('php.html', []),
                'subscriberLabel' =>  getNick($request->vars),
                'description' => 'Személyre szabott tanítás JavaScript, React, Angular és PHP témákban.',
            ]);
        });
        $r->get('/javascript-az-alapoktol', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');
            echo $twig->render('wrapper.twig', [
                'structuredData' => self::organizationStructuredData(),
                'title' => "JavaScript tréning",
                'content' => $twig->render('js.html', []),
                'subscriberLabel' =>  getNick($request->vars),
                'description' => 'Személyre szabott tanítás JavaScript, React, Angular és PHP témákban.',
            ]);
        });
        $r->get('/nodejs-es-mongodb', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');
            echo $twig->render('wrapper.twig', [
                'structuredData' => self::organizationStructuredData(),
                'title' => "Node.JS és MongoDB tréning",
                'content' => $twig->render('node.html', []),
                'subscriberLabel' =>  getNick($request->vars),
                'description' => 'Személyre szabott tanítás JavaScript, React, Angular és PHP témákban.',
            ]);
        });
        $r->get('/online-trening', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');
            echo $twig->render('wrapper.twig', [
                'structuredData' => self::organizationStructuredData(),
                'title' => "Online tréning",
                'content' => $twig->render('online.html', []),
                'subscriberLabel' =>  getNick($request->vars),
                'description' => 'Személyre szabott tanítás JavaScript, React, Angular és PHP témákban.',
            ]);
        });

        $r->post('/api/request-membership', function (Request $request) use ($conn, $twig) {

            $byEmail = (new SubscriberLister($conn))->list(Router::where('email', 'eq', $request->body['email']));

            if ($byEmail->getCount() !== 0) {
                $params = ['error=emailTaken'];
                header('Location: ' .  $_SERVER['HTTP_REFERER']  . Router::mergeQueries($_SERVER['HTTP_REFERER'], $params));

                return;
            }

            if (!filter_var($request->body['email'], FILTER_VALIDATE_EMAIL)) {
                $params = ['error=invalidEmail'];
                header('Location: ' .  $_SERVER['HTTP_REFERER']  . Router::mergeQueries($_SERVER['HTTP_REFERER'], $params));
                return;
            }

            $token = uniqid();
            (new SubscriberSaver($conn))->Save(new NewSubscriber(
                $request->body['email'],
                password_hash($request->body['password'], PASSWORD_DEFAULT),
                0,
                $token,
                time(),
                0
            ));

            $body = $twig->render('verification-email.twig', [
                'email' => $request->body['email'],
                'link' => Router::siteUrl() . "/megerosites/" . $token . "?referer=" . $_SERVER['HTTP_REFERER'],
            ]);

            $params = ['registrationEmailSent=1'];
            header('Location: ' .  $_SERVER['HTTP_REFERER']  . Router::mergeQueries($_SERVER['HTTP_REFERER'], $params));

            (new MessageSaver($conn))->Save(new NewMessage(
                $request->body['email'],
                'Megerősítés egyetlen kattintással',
                $body,
                "notSent",
                0,
                null,
                time()
            ));
        });

        $r->get('/megerosites/{token}', function (Request $request) use ($conn, $twig) {
            $byToken = (new SubscriberLister($conn))->list(Router::where('verificationToken', 'eq', $request->vars['token']));

            if ($byToken->getCount() === 0) {
                header('Location: /');
                return;
            }

            $subscriber = $byToken->getEntities()[0];

            if ($subscriber->getIsVerified()) {
                header('Location: /');
                return;
            }

            $byToken = (new SubscriberPatcher($conn))->patch($subscriber->getId(), new PatchedSubscriber(null, null, 1, '', null, null));
            session_start();
            $_SESSION['subscriberId'] = $subscriber->getId();
            $requestUri = parse_url($_GET['referer'])['path'];
            $params = ['registrationSuccessful=1'];
            header('Location: ' .  $requestUri . Router::mergeQueries($_GET['referer'], $params));
        });

        $r->get('/cikkek', $initSubscriberSession, function (Request $request) use ($conn, $twig) {

            header('Content-Type: text/html; charset=UTF-8');
            $posts = (new ListController(
                new OperationError(),
                new SqlLister($request->connection),
                new Pager()
            ))->list([
                'from' => 0,
                'limit' => 10,
                'orderBy' => json_encode([
                    'key' => 'createdAt',
                    'value' => 'desc'
                ]),
                'filters' => [
                    'key' => 'isActive',
                    'operator' => 'eq',
                    'value' => '1'
                ]
            ]);

            echo $twig->render('wrapper.twig', [
                'subscriberLabel' =>  getNick($request->vars),
                'title' => 'Cikkek',
                'description' => 'Olvass és tanulj JavaScript, PHP, Docker és egyéb szoftverfejlesztői témákban',
                'content' => $twig->render('posts.twig', [
                    'posts' => alignToRows($posts->getResults(), 3),
                ]),
            ]);
        });

        $r->get('/adatvedelmi-szabalyzat', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');
            echo $twig->render('wrapper.twig', [
                'structuredData' => self::organizationStructuredData(),
                'title' => "Adatvédelmi szabályzat",
                'content' => $twig->render('privacy-policy.html', []),
                'subscriberLabel' =>  getNick($request->vars),
                'description' => 'A Kódbázis adatvédelmi szabályzata',
                'title' => 'Adatvédelmi szabályzat',
                'noIndex' => true,
            ]);
        });

        $r->get('/adattovabbitasi-nyilatkozat', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');
            echo $twig->render('wrapper.twig', [
                'structuredData' => self::organizationStructuredData(),
                'title' => "Adattovábbítási nyilatkozat",
                'content' => $twig->render('simplepay-legal.html', []),
                'subscriberLabel' =>  getNick($request->vars),
                'description' => 'Az OTP simplepay adattovábbítási nyilatkozata',
                'title' => 'Adattovábbítási nyilatkozat',
                'noIndex' => true,
            ]);
        });
        $r->get('/aszf', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');
            echo $twig->render('wrapper.twig', [
                'structuredData' => self::organizationStructuredData(),
                'title' => "Általános szerződési feltételek",
                'content' => $twig->render('aszf.html', []),
                'subscriberLabel' =>  getNick($request->vars),
                'description' => 'A Kódbázis általános szerződési feltételei',
                'noIndex' => true,
            ]);
        });

        $r->get(
            '/kupon-bevaltasa/{ref}',
            function (Request $request) use ($conn, $twig) {
                $coupons = fetchAll(
                    $conn->query(
                        "SELECT * FROM `coupons` WHERE `ref` = '" . $request->vars['ref'] . "'"
                    )
                );

                if (!count($coupons)) {
                    header("Location: /" . $request->query['c']);
                    return;
                }

                session_start();
                $_SESSION['subscriberId'] = (int)$coupons[0]['issuedTo'];

                header("Location: /" . $request->query['c']);
            }
        );

        $r->post('/api/apply-coupon/{courseId}', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            $stmt = $conn->prepare(
                "SELECT * FROM coupons WHERE 
                    courseId = ? AND
                    code = ? AND
                    redeemedBy IS NULL AND
                    validUntil > UNIX_TIMESTAMP()
                "
            );
            $courseId = $request->vars['courseId'];
            $code = $request->body["code"];
            $stmt->bind_param('ss', $courseId, $code);
            $stmt->execute();
            $coupons = fetchAll($stmt->get_result());

            if (!count($coupons)) {
                http_response_code(401);
                return;
            }

            (new CouponPatcher($conn))->patch($coupons[0]['id'], new PatchedCoupon($_SESSION['subscriberId']));
        });

        $r->post('/api/order-course/{courseId}', $initSubscriberSession, function (Request $request) use ($conn, $twig) {


            $courseById = (new CourseLister($conn))->list(Router::where('id', 'eq', $request->vars['courseId']));

            if (!$courseById->getCount()) {
                header('Location: /' . $courseById->getEntities()[0]->getSlug());
                return;
            }

            $subscriberCourses = (new SubscriberCourseLister($conn))->list(new Query(
                1000,
                0,
                new Filter(
                    'and',
                    new Clause('eq', 'subscriberId', $_SESSION['subscriberId']),
                    new Clause('eq', 'courseId', $request->vars['courseId']),
                ),
                new OrderBy('id', 'asc')
            ));

            if ($subscriberCourses->getCount()) {
                header('Location: /' . $courseById->getEntities()[0]->getSlug());
                return;
            }

            if ($request->body['purchaseType'] === 'invoice') {
                $fields = ['name', 'taxNumber', 'zip', 'city', 'address'];
                $isValid = true;
                foreach ($fields as $field) {
                    if (!isset($request->body[$field]) || !$request->body[$field]) {
                        $isValid = false;
                        break;
                    }
                }
                if (!$isValid) {
                    $params = ['error=requiredFieldMissing'];
                    header('Location: ' .  $_SERVER['HTTP_REFERER']  . Router::mergeQueries($_SERVER['HTTP_REFERER'], $params));
                    return;
                }
            }

            (new SubscriberCourseSaver($conn))->Save(
                new NewSubscriberCourse(
                    $_SESSION['subscriberId'],
                    $request->vars['courseId'],
                    $request->body['name'] ?? '',
                    $request->body['taxNumber'] ?? '',
                    $request->body['zip'] ?? 0,
                    $request->body['city'] ?? '',
                    $request->body['address'] ?? '',
                    $request->body['purchaseType'],
                    '',
                    false,
                    false,
                    false,
                    time(),
                )
            );
            header('Location: /' . $courseById->getEntities()[0]->getSlug());
        });

        $r->get('/api/isPaymentVerified/{subscriberCourseId}', $initSubscriberSession, function (Request $request) use ($conn) {
            header('Content-Type: application/json');
            if (!isset($_SESSION['subscriberId'])) {
                http_response_code(401);
                json_encode(['error', 'unauthorized']);
                return;
            }
            $byId = (new SubscriberCourseById($conn))->byId($request->vars['subscriberCourseId']);
            if ($byId->getSubscriberId() !== $_SESSION['subscriberId']) {
                http_response_code(401);
                json_encode(['error', 'unauthorized']);
                return;
            }
            echo json_encode(['isVerified' => (bool)$byId->getIsVerified()]);
        });

        $r->get('/embeddable/gif/{id}/gif', function (Request $request) use ($conn, $twig) {
            header('Access-Control-Allow-Origin: *');
            header('Content-type: image/gif');
            $item = (new SqlByIdGetter($conn))->byId($request->vars['id']);
            $raw = json_decode($item->getRaw(), true);
            $content = file_get_contents('../embeddable/gif/' . $raw['fileName']);
            echo $content;
        });
        $r->get('/embeddable/codeAssistant/{id}/fileChanges', function (Request $request) use ($conn, $twig) {
            header('Access-Control-Allow-Origin: *');
            $item = (new SqlByIdGetter($conn))->byId($request->vars['id']);
            $raw = json_decode($item->getRaw(), true);
            $content = file_get_contents('../embeddable/codeAssistant/' . $raw['filechangesName']);
            echo $content;
        });

        $r->get('/embeddable/codeAssistantGif/{id}/fileChanges', function (Request $request) use ($conn, $twig) {
            header('Access-Control-Allow-Origin: *');
            $item = (new SqlByIdGetter($conn))->byId($request->vars['id']);
            $raw = json_decode($item->getRaw(), true);
            $content = file_get_contents('../embeddable/codeAssistantGif/' . $raw['filechangesName']);
            echo $content;
        });
        $r->get('/embeddable/codeAssistantGif/{id}/gif', function (Request $request) use ($conn, $twig) {
            header('Access-Control-Allow-Origin: *');
            header('Content-type: image/gif');
            $item = (new SqlByIdGetter($conn))->byId($request->vars['id']);
            $raw = json_decode($item->getRaw(), true);
            $content = file_get_contents('../embeddable/codeAssistantGif/' . $raw['fileName']);
            echo $content;
        });

        $r->get('/embeddable/codeAssistantYoutube/{id}/fileChanges', function (Request $request) use ($conn, $twig) {
            header('Access-Control-Allow-Origin: *');
            $item = (new SqlByIdGetter($conn))->byId($request->vars['id']);
            $raw = json_decode($item->getRaw(), true);
            $content = file_get_contents('../embeddable/codeAssistantYoutube/' . $raw['filechangesName']);
            echo $content;
        });
        $r->get('/embeddable/codeAssistantVimeo/{id}/fileChanges', function (Request $request) use ($conn, $twig) {
            header('Access-Control-Allow-Origin: *');
            $item = (new SqlByIdGetter($conn))->byId($request->vars['id']);
            $raw = json_decode($item->getRaw(), true);
            if (!isset($raw['filechangesName'])) {
                return;
            }
            $path = '../embeddable/codeAssistantVimeo/' . $raw['filechangesName'];
            $ext = pathinfo($path)['extension'];
            header("Content-type: " . ($ext === 'json' ? 'application/json' : 'application/xml'));
            $content = file_get_contents($path);
            echo $content;
        });

        $r->get('/cikkek/{slug}', $initSubscriberSession, Posts::postSingleHandler($conn, $twig));

        $r->get('/{course-slug}', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');
            $courseBySlug = (new CourseLister($conn))->list(Router::where('slug', 'eq', $request->vars['course-slug']));
            $course = $courseBySlug->getEntities()[0] ?? null;

            if (!$course) {
                http_response_code(404);
                echo $twig->render('404.twig');
                return;
            }

            $allEpisodesInCourse = (new EpisodeLister($conn))->list(new Query(
                1000,
                0,
                new Filter(
                    'and',
                    new Clause('eq', 'courseId', $course->getId()),
                    new Clause('eq', 'isActive', 1),
                ),
                new OrderBy('position', 'asc')
            ))->getEntities();

            $quotes = (new QuoteLister($conn))->list(new Query(
                1000,
                0,
                new Clause('eq', 'courseId', $course->getId()),
                new OrderBy('position', 'asc')
            ))->getEntities();

            $specs = (new SpecLister($conn))->list(new Query(
                1000,
                0,
                new Clause('eq', 'courseId', $course->getId()),
                new OrderBy('position', 'asc')
            ))->getEntities();

            $subscribersInCourse = (new SubscriberCourseLister($conn))->list(new Query(
                1000,
                0,
                new Filter(
                    'and',
                    new Clause('eq', 'isPayed', '1'),
                    new Clause('eq', 'courseId', $course->getId()),
                ),
                new OrderBy('id', 'asc')
            ));

            // not logged in
            if (!isset($_SESSION['subscriberId'])) {
                echo $twig->render('wrapper.twig', [
                    'structuredData' => courseToStructuredData($course, $conn),
                    'title' => $course->getTitle(),
                    'description' => $course->getDescription(),
                    'content' => $twig->render('paywall.twig', [
                        'course' => $course,
                        'url' => Router::siteUrl() . parse_url(Router::siteUrl() . $_SERVER['REQUEST_URI'])['path'],
                        'discountedPrice' => getDiscountedPrice($course, 0, $conn),
                        'numberOfSubscribers' => $subscribersInCourse->getCount(),
                        'quotes' => $quotes,
                        'specs' => $specs,
                        'contentWithEmbeddables' => $course->getContent(),
                        'paywallForm' => $twig->render('sub-reg-panel.twig', [
                            'isCouponRedeemed' => false,
                            'isLogin' => isset($_GET['isLogin']),
                            'isLoggedIn' => isset($_SESSION['subscriberId']),
                            'loginSuccess' => isset($_GET['loginSuccess']),
                            'registrationEmailSent' => isset($_GET['registrationEmailSent']),
                            'isPasswordModificationSuccess' => isset($_GET['isPasswordModificationSuccess']),
                            'error' => $_GET['error'] ?? '',
                            'email' => $_GET['email'] ?? '',
                        ]),
                        'episodeList' => renderEpisodeList($twig, $course, $allEpisodesInCourse),
                        'registrationSuccessful' => isset($_GET['registrationSuccessful']),
                    ]),
                    'subscriberLabel' =>  getNick($request->vars),
                    'styles' => [
                        ['path' => 'css/login.css'],
                        ['path' => 'css/promo.css'],
                        ['path' => 'css/fonts/fontawesome/css/fontawesome-all.css'],

                    ],
                    'ogTags' => getCourseOgTags($course),
                ]);
                return;
            }

            $subscriberCourses = (new SubscriberCourseLister($conn))->list(new Query(
                1000,
                0,
                new Filter(
                    'and',
                    new Clause('eq', 'subscriberId', $_SESSION['subscriberId']),
                    new Clause('eq', 'courseId', $course->getId()),
                ),
                new OrderBy('id', 'asc')
            ));

            // kupon?
            $coupons = getRedeemedAndValidCoupon($conn, $course, $_SESSION['subscriberId']);
            $isCouponRedeemed = $coupons->getCount() > 0;

            // not ordered
            if (!$subscriberCourses->getCount()) {
                echo $twig->render('wrapper.twig', [
                    'structuredData' => courseToStructuredData($course, $conn),
                    'title' => $course->getTitle(),
                    'description' => $course->getDescription(),
                    'content' => $twig->render('paywall.twig', [
                        'course' => $course,
                        'url' => Router::siteUrl() . parse_url(Router::siteUrl() . $_SERVER['REQUEST_URI'])['path'],
                        'discountedPrice' => getDiscountedPrice($course, $_SESSION['subscriberId'], $conn),
                        'numberOfSubscribers' => $subscribersInCourse->getCount(),
                        'quotes' => $quotes,
                        'specs' => $specs,
                        'contentWithEmbeddables' => $course->getContent(),
                        'paywallForm' => $twig->render('paywall-form.twig', [
                            'isCouponRedeemed' => $isCouponRedeemed,
                            'course' => $course,
                            'isInvoice' => isset($_GET['isInvoice']),
                            'error' => $_GET['error'] ?? '',
                        ]),
                        'episodeList' => renderEpisodeList($twig, $course, $allEpisodesInCourse),
                        'registrationSuccessful' => isset($_GET['registrationSuccessful']),
                        'loginSuccess' => isset($_GET['loginSuccess']),
                    ]),
                    'subscriberLabel' =>  getNick($request->vars),
                    'styles' => [
                        ['path' => 'css/login.css'],
                        ['path' => 'css/promo.css'],
                        ['path' => 'css/fonts/fontawesome/css/fontawesome-all.css'],
                    ],
                    'ogTags' => getCourseOgTags($course),
                ]);
                return;
            }

            // not payed            
            $subscriberCourse = $subscriberCourses->getEntities()[0];

            if (!$subscriberCourse->getIsPayed()) {
                echo $twig->render('wrapper.twig', [
                    'structuredData' => courseToStructuredData($course, $conn),
                    'title' => $course->getTitle(),
                    'description' => $course->getDescription(),
                    'content' => $twig->render('paywall.twig', [
                        'course' => $course,
                        'url' => Router::siteUrl() . parse_url(Router::siteUrl() . $_SERVER['REQUEST_URI'])['path'],
                        'discountedPrice' => getDiscountedPrice($course, $_SESSION['subscriberId'], $conn),
                        'numberOfSubscribers' => $subscribersInCourse->getCount(),
                        'quotes' => $quotes,
                        'specs' => $specs,
                        'contentWithEmbeddables' => $course->getContent(),
                        'paywallForm' => $twig->render('paywall-form.twig', [
                            'isCouponRedeemed' => $isCouponRedeemed,
                            'subscriberCourse' => $subscriberCourse,
                            'course' => $course,
                            'isInvoice' => $subscriberCourse->getPurchaseType() === 'invoice',
                            'error' => $_GET['error'] ?? '',
                            'transactionId' => $_GET['transactionId'] ?? '',
                            'paymentUrl' => PaymentRoutes::getPaymentUrl($course, $subscriberCourse, $conn),
                        ]),
                        'episodeList' => renderEpisodeList($twig, $course, $allEpisodesInCourse),
                    ]),
                    'subscriberLabel' =>  getNick($request->vars),
                    'styles' => [
                        ['path' => 'css/login.css'],
                        ['path' => 'css/promo.css'],
                        ['path' => 'css/fonts/fontawesome/css/fontawesome-all.css'],
                    ],
                    'ogTags' => getCourseOgTags($course),
                ]);
                return;
            }


            // waiting for ipn
            if (!$subscriberCourse->getIsVerified()) {

                echo $twig->render('wrapper.twig', [
                    'structuredData' => courseToStructuredData($course, $conn),
                    'title' => $course->getTitle(),
                    'description' => $course->getDescription(),
                    'content' => $twig->render('paywall.twig', [
                        'course' => $course,
                        'url' => Router::siteUrl() . parse_url(Router::siteUrl() . $_SERVER['REQUEST_URI'])['path'],
                        'discountedPrice' => getDiscountedPrice($course, $_SESSION['subscriberId'], $conn),
                        'numberOfSubscribers' => $subscribersInCourse->getCount(),
                        'quotes' => $quotes,
                        'specs' => $specs,
                        'contentWithEmbeddables' => $course->getContent(),
                        'paywallForm' => $twig->render('paywall-form.twig', [
                            'isCouponRedeemed' => $isCouponRedeemed,
                            'subscriberCourse' => $subscriberCourse,
                            'course' => $course,
                            'isInvoice' => $subscriberCourse->getPurchaseType() === 'invoice',
                            'error' => $_GET['error'] ?? '',
                            'transactionSuccessful' => $_GET['transactionSuccessful'] ?? '',
                            'transactionId' => $_GET['transactionId'] ?? '',
                            'orderRef' => $_GET['orderRef'] ?? '',
                            'paymentUrl' => '',
                            'subscriber' => $request->vars['subscriber'],
                        ]),
                        'episodeList' => renderEpisodeList($twig, $course, $allEpisodesInCourse),
                    ]),
                    'subscriberLabel' =>  getNick($request->vars),
                    'styles' => [
                        ['path' => 'css/login.css'],
                        ['path' => 'css/promo.css'],
                        ['path' => 'css/fonts/fontawesome/css/fontawesome-all.css'],
                    ],
                    'ogTags' => getCourseOgTags($course),
                ]);
                return;
            }

            echo $twig->render('wrapper.twig', [
                'subscriberLabel' =>  getNick($request->vars),
                'structuredData' => courseToStructuredData($course, $conn),
                'title' => $course->getTitle(),
                'description' => $course->getDescription(),
                'content' => $twig->render('course.twig', [
                    'course' => $course,
                    'subscriberCourse' => $subscriberCourse,
                    'episodes' => alignToRows($allEpisodesInCourse, 3),
                    'isSuccess' => $_GET['isSuccess'] ?? '',
                ]),
                'styles' => [
                    ['path' => 'css/promo.css'],
                ],
                'ogTags' => getCourseOgTags($course),
            ]);
        });

        $r->get(
            '/{course-slug}/{episode-slug}',
            $initSubscriberSession,
            Episodes::episodeSingleHandler($conn, $twig)
        );
    }
}

function courseToStructuredData2($course)
{
    return json_encode([
        "@context" => "https://schema.org",
        "@type" => "Course",
        "name" => $course->getTitle() . ' KEZDŐ FEJLESZTŐKNEK',
        "description" => $course->getDescription(),
        "provider" => [
            "@type" => "Organization",
            "name" => "Kódbázis",
            "sameAs" => Router::siteUrl()
        ]
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

function courseToStructuredData($course, $conn)
{
    $quotes = (new QuoteLister($conn))->list(new Query(
        1000,
        0,
        new Clause('eq', 'courseId', $course->getId()),
        new OrderBy('position', 'asc')
    ));

    $now = time();
    $plusOneMonth = date('U', strtotime('+1 month', $now));
    return json_encode([
        "@context" => "https://schema.org",
        "@type" => "Product",
        "name" => $course->getTitle(),
        "sku" => $course->getId(),
        "description" => $course->getDescription(),
        "brand" => [
            "@type" => "Brand",
            "name" => "Kódbázis"
        ],
        "image" => [Router::siteUrl() . '/public/files/' . $course->getImgUrl()],
        "offers" => [
            "@type" => "Offer",
            "url" => Router::siteUrl() . '/' . $course->getSlug(),
            "priceCurrency" => "HUF",
            "price" => getDiscountedPrice($course, 0),
            "priceValidUntil" => (new DateTime())->setTimestamp($plusOneMonth)->format('Y-m-d'),
            "availability" => "https://schema.org/InStock"
        ],
        "review" => array_map(function ($quote) {
            return [
                "@type" => "Review",
                "reviewRating" => [
                    "@type" => "Rating",
                    "ratingValue" => $quote->getRating(),
                ],
                "reviewBody" => $quote->getContent(),
                "author" => [
                    "@type" => "Person",
                    "name" => $quote->getAuthor(),
                ],
            ];
        }, $quotes->getEntities()),
        "aggregateRating" => [
            "@type" => "AggregateRating",
            "ratingValue" => "5",
            "reviewCount" => $quotes->getCount(),
        ],
        "mpn" => "925872",
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

function renderEpisodeList($twig, $course, $allEpisodesInCourse)
{
    return $twig->render('intro-course-list.twig', [
        'isPromo' => true,
        'course' => $course,
        'episodes' => alignToRows($allEpisodesInCourse, 2),
    ]);
}

function getNick($vars)
{
    if (!isset($vars['subscriber'])) {
        return '';
    }

    return $vars['subscriber']->getEmail();
}

function getCourseOgTags($course)
{
    return [
        [
            'property' => 'og:url',
            'content' => Router::siteUrl() . parse_url(Router::siteUrl() . $_SERVER['REQUEST_URI'])['path'],
        ],
        [
            'property' => 'og:type',
            'content' => 'article',
        ],
        [
            'property' => 'og:title',
            'content' => $course->getTitle(),
        ],
        [
            'property' => 'og:image',
            'content' => Router::siteUrl() . '/public/files/md-' . $course->getImgUrl(),
        ],
        [
            'property' => 'og:description',
            'content' => $course->getDescription(),
        ],
        [
            'property' => 'fb:app_id',
            'content' => '705894336804251',
        ],
    ];
}

function getDiscountedPrice($course, $subscriberId, $conn = null)
{

    $discount = getDiscount($course, $subscriberId, $conn);

    $multiplier = (100 - $discount) / 100;
    $x = $course->getPrice() * $multiplier;
    return round($x / 10) * 10;
}

function getDiscount($course, $subscriberId, $conn = null)
{

    if ($course->getDiscount()) {
        return $course->getDiscount();
    }

    if (!isset($_SESSION['subscriberId'])) {
        return 0;
    }

    if (!$subscriberId || !$conn) {
        return 0;
    }

    $coupons = getRedeemedAndValidCoupon($conn, $course, $subscriberId);

    if (!$coupons->getCount()) {
        return 0;
    }

    return  $coupons->getEntities()[0]->getDiscount();
}

function getRedeemedAndValidCoupon($conn, $course, $subscriberId)
{
    return (new CouponLister($conn))->list(
        new Query(
            1,
            0,
            new Filter(
                'and',
                new Clause('eq', 'courseId', $course->getId()),
                new Filter(
                    'and',
                    new Clause('eq', 'redeemedBy', $subscriberId),
                    new Clause('gt', 'validUntil', time()),
                )
            ),
            new OrderBy('id', 'asc')
        )
    );
}

function getCourseItems($conn)
{
    $courses = (new CourseLister($conn))->list(new Query(
        15,
        0,
        [],
        new OrderBy('createdAt', 'desc'),
        []
    ));

    return array_map(function ($course) use ($conn) {
        $subscribersInCourse = (new SubscriberCourseLister($conn))->list(new Query(
            1000,
            0,
            new Filter(
                'and',
                new Clause('eq', 'isVerified', '1'),
                new Clause('eq', 'courseId', $course->getId()),
            ),
            new OrderBy('id', 'asc')
        ));


        $quotes = (new QuoteLister($conn))->list(new Query(
            1000,
            0,
            new Clause('eq', 'courseId', $course->getId()),
            new OrderBy('position', 'asc')
        ))->getEntities();

        $specs = (new SpecLister($conn))->list(new Query(
            1000,
            0,
            new Clause('eq', 'courseId', $course->getId()),
            new OrderBy('position', 'asc')
        ))->getEntities();

        return [
            "course" => $course,
            "discountedPrice" => getDiscountedPrice($course, 0),
            "numberOfSubscribers" => $subscribersInCourse->getCount(),
            "quotes" => $quotes,
            "specs" => $specs
        ];
    },  $courses->getEntities());
}
