<?php

namespace Kodbazis;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Request;
use mysqli;
use Twig\Environment;
use Kodbazis\Mailer\Mailer;
use Kodbazis\Generated\Paging\Pager;
use Kodbazis\Generated\Post\Listing\ListController;
use Kodbazis\Generated\Repository\Post\SqlLister;
use Kodbazis\Generated\Repository\Subscriber\SqlSaver as SubscriberSaver;
use Kodbazis\Generated\Repository\Subscriber\SqlLister as SubscriberLister;
use Kodbazis\Generated\Repository\Subscriber\SqlPatcher as SubscriberPatcher;
use Kodbazis\Generated\Repository\Embeddable\SqlByIdGetter;
use Kodbazis\Generated\Repository\Course\SqlLister as CourseLister;
use Kodbazis\Generated\Repository\SubscriberCourse\SqlLister as SubscriberCourseLister;
use Kodbazis\Generated\Repository\SubscriberCourse\SqlSaver as SubscriberCourseSaver;
use Kodbazis\Generated\Repository\SubscriberCourse\SqlDeleter as SubscriberCourseDeleter;
use Kodbazis\Generated\Repository\SubscriberCourse\SqlByIdGetter as SubscriberCourseById;
use Kodbazis\Generated\Repository\Episode\SqlLister as EpisodeLister;
use Kodbazis\Episodes;
use Kodbazis\Generated\Listing\Clause;
use Kodbazis\Generated\Listing\Filter;
use Kodbazis\Generated\Listing\OrderBy;
use Kodbazis\Generated\Listing\Query;
use Kodbazis\Generated\Subscriber\Patch\PatchedSubscriber;
use Kodbazis\Generated\Subscriber\Save\NewSubscriber;
use Kodbazis\Generated\SubscriberCourse\Save\NewSubscriberCourse;
use SzamlaAgent\Document\Receipt\Receipt;

class PublicSite
{

    public static function initSubscriberSession($conn)
    {
        return function (Request $request) use ($conn) {
            session_start();
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

    public static function getRoutes(Pipeline $r, mysqli $conn, Environment $twig)
    {

        $initSubscriberSession = self::initSubscriberSession($conn);

        $r->get('/', self::initSubscriberSession($conn), function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');

            echo $twig->render('wrapper.twig', [
                'content' => $twig->render('home.twig', []),
                'subscriberLabel' =>  getNick($request->vars),
                'structuredData' => json_encode([
                    "@context" => "https://schema.org",
                    "@type" => "Organization",
                    "url" => Router::siteUrl(),
                    "logo" => Router::siteUrl() . "/public/images/logo-dark.png"
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'scripts' => [
                    ['path' => 'js/jquery.js'],
                    ['path' => 'js/application.js'],
                ]
            ]);
        });

        $r->get('/elfelejtett-jelszo', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');

            if ($request->vars['subscriber']) {
                header('Location: /');
                return;
            }

            echo $twig->render('wrapper.twig', [
                'content' => $twig->render('forgot-password.twig', [
                    'isError' => isset($_GET['isError']),
                    'emailSent' => isset($_GET['emailSent']),
                ]),
                'subscriberLabel' =>  getNick($request->vars),
                'styles' => [
                    ['path' => 'css/login.css']
                ],
            ]);
        });

        $r->post('/api/forgot-password', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');

            if ($request->vars['subscriber']) {
                header('Location: /');
                return;
            }

            $byEmail = (new SubscriberLister($conn))->list(Router::where('email', 'eq', $request->body['email']));

            if ($byEmail->getCount() === 0) {
                header('Location: /elfelejtett-jelszo?isError=1');
                return;
            }

            $subscriber = $byEmail->getEntities()[0];
            $token = uniqid();

            (new SubscriberPatcher($conn))->patch(
                $subscriber->getId(),
                new PatchedSubscriber(null, null, 1, $token)
            );

            $msg = $twig->render('forgot-password-email.twig', [
                'email' => $subscriber->getEmail(),
                'link' => Router::siteUrl() . "/jelszo-megvaltoztatasa/" . $token,
            ]);

            @(new Mailer())->sendMail($subscriber->getEmail(), 'Jelszó megváltoztatása', $msg);

            header('Location: /elfelejtett-jelszo?emailSent=1');
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
            $byToken = (new SubscriberPatcher($conn))->patch($subscriber->getId(), new PatchedSubscriber(null, $password, 1, ''));
            header('Location: /react-kurzus?isPasswordModificationSuccess=1');
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
                'subscriberLabel' =>  getNick($request->vars),
                'content' => $twig->render('subscriber-login.twig', [
                    'subscriberLabel' =>  getNick($request->vars),
                    'isLoggedIn' => isset($_SESSION['subscriberId']),
                    'error' => $_GET['error'] ?? '',
                    'loginSuccess' => isset($_GET['loginSuccess']),
                    'isPasswordModificationSuccess' => isset($_GET['isPasswordModificationSuccess']),
                    'email' => $_GET['email'] ?? '',
                ]),
                'styles' => [
                    ['path' => 'css/login.css']
                ],
            ]);
        });

        $r->get('/feliratkozas', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');
            echo $twig->render('wrapper.twig', [
                'subscriberLabel' =>  getNick($request->vars),
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
                'subscriberLabel' =>  getNick($request->vars),
                'content' => $twig->render('cookie-policy.html', []),
            ]);
        });

        $r->post('/api/subscriber-logout', function (Request $request) use ($conn, $twig) {
            session_start();
            session_destroy();
            $requestUri = parse_url($_SERVER['HTTP_REFERER'])['path'];
            header('Location: ' . $requestUri);
        });

        $r->post('/api/subscriber-login', function (Request $request) use ($conn, $twig) {
            $byEmail = (new SubscriberLister($conn))->list(Router::where('email', 'eq', $request->body['email']));

            $parsed = parse_url($_SERVER['HTTP_REFERER']);
            $requestUri = $parsed['path'];


            if ($byEmail->getCount() === 0) {
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

        $r->get('/elerhetoseg', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');

            echo $twig->render('wrapper.twig', [
                'content' => $twig->render('contact.twig', []),
                'subscriberLabel' =>  getNick($request->vars),
                'description' => 'Elérhetőség'
            ]);
        });
        $r->get('/trening', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');
            echo $twig->render('wrapper.twig', [
                'content' => $twig->render('training.twig', []),
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
                time()
            ));

            $msg = $twig->render('verification-email.twig', [
                'email' => $request->body['email'],
                'link' => Router::siteUrl() . "/megerosites/" . $token . "?referer=" . $_SERVER['HTTP_REFERER'],
            ]);
            @(new Mailer())->sendMail($request->body['email'], 'Megerősítés egyetlen kattintással', $msg);

            $params = ['registrationEmailSent=1'];
            header('Location: ' .  $_SERVER['HTTP_REFERER']  . Router::mergeQueries($_SERVER['HTTP_REFERER'], $params));
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

            $byToken = (new SubscriberPatcher($conn))->patch($subscriber->getId(), new PatchedSubscriber(null, null, 1, ''));
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
                'content' => $twig->render('posts.twig', [
                    'posts' => alignToRows($posts->getResults(), 3),
                ]),
            ]);
        });

        $r->get('/adatvedelmi-szabalyzat', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');
            echo $twig->render('wrapper.twig', [
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
                'content' => $twig->render('aszf.html', []),
                'subscriberLabel' =>  getNick($request->vars),
                'description' => 'A Kódbázis általános szerződési feltételei',
                'title' => 'Általános szerződési feltételei',
                'noIndex' => true,
            ]);
        });

        // $r->get('/api/test', function () {
        //     Invoice::sendReceipt('shop@kodbazis.hu', 'Teszt', 1000);
        // });

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
            header('Location: /' . $courseById->getEntities()[0]->getSlug() . '#paymentPhase');
        });

        $r->post('/api/delete-course-order/{subscriberCourseId}', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            if (!isset($_SESSION['subscriberId'])) {
                header('Location: /react-kurzus');
                return;
            }


            (new SubscriberCourseDeleter($conn))->delete($request->vars['subscriberCourseId']);
            header('Location: /react-kurzus');
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
                echo $twig->render('404.twig');
                return;
            }

            $query = new Query(
                1000,
                0,
                new Filter(
                    'and',
                    new Clause('eq', 'courseId', $course->getId()),
                    new Clause('eq', 'isActive', 1),
                ),
                new OrderBy('position', 'asc')
            );

            $allEpisodesInCourse = (new EpisodeLister($conn))->list($query)->getEntities();

            // render course description
            // render course img
            // render course episodes
            // render course intro video


            // not logged in
            if (!isset($_SESSION['subscriberId'])) {
                echo $twig->render('wrapper.twig', [
                    'structuredData' => courseToStructuredData($course),
                    'content' => $twig->render('react-paywall.twig', [
                        'paywallForm' => $twig->render('sub-reg-panel.twig', [
                            'isLogin' => isset($_GET['isLogin']),
                            'isLoggedIn' => isset($_SESSION['subscriberId']),
                            'loginSuccess' => isset($_GET['loginSuccess']),
                            'registrationEmailSent' => isset($_GET['registrationEmailSent']),
                            'isPasswordModificationSuccess' => isset($_GET['isPasswordModificationSuccess']),
                            'error' => $_GET['error'] ?? '',
                            'email' => $_GET['email'] ?? '',
                        ]),
                        'episodeList' => renderEpisodeList($twig, $course, $allEpisodesInCourse),
                    ]),
                    'subscriberLabel' =>  getNick($request->vars),
                    'styles' => [
                        ['path' => 'css/login.css'],
                        ['path' => 'css/promo.css'],
                        ...Embeddables::getKodsegedStyles(),
                    ],
                    'scripts' => [
                        ...Embeddables::getKodsegedScripts(),
                    ],
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

            // not ordered
            if (!$subscriberCourses->getCount()) {
                echo $twig->render('wrapper.twig', [
                    'structuredData' => courseToStructuredData($course),
                    'content' => $twig->render('react-paywall.twig', [
                        'paywallForm' => $twig->render('paywall-form.twig', [
                            'course' => $course,
                            'isInvoice' => isset($_GET['isInvoice']),
                            'error' => $_GET['error'] ?? '',
                        ]),
                        'episodeList' => renderEpisodeList($twig, $course, $allEpisodesInCourse),
                        'registrationSuccessful' => isset($_GET['registrationSuccessful']),
                    ]),
                    'subscriberLabel' =>  getNick($request->vars),
                    'styles' => [
                        ...Embeddables::getKodsegedStyles(),
                        ['path' => 'css/login.css'],
                        ['path' => 'css/promo.css'],
                    ],
                    'scripts' => [
                        ...Embeddables::getKodsegedScripts(),
                    ],
                ]);
                return;
            }

            // not payed            
            $subscriberCourse = $subscriberCourses->getEntities()[0];

            if (!$subscriberCourse->getIsPayed()) {
                echo $twig->render('wrapper.twig', [
                    'structuredData' => courseToStructuredData($course),
                    'content' => $twig->render('react-paywall.twig', [
                        'paywallForm' => $twig->render('paywall-form.twig', [
                            'subscriberCourse' => $subscriberCourse,
                            'course' => $course,
                            'isInvoice' => $subscriberCourse->getPurchaseType() === 'invoice',
                            'error' => $_GET['error'] ?? '',
                            'transactionId' => $_GET['transactionId'] ?? '',
                            'paymentUrl' => PaymentRoutes::getPaymentUrl($course, $subscriberCourse, $request->vars['subscriber'], $conn),
                        ]),
                        'episodeList' => renderEpisodeList($twig, $course, $allEpisodesInCourse),
                    ]),
                    'subscriberLabel' =>  getNick($request->vars),
                    'styles' => [
                        ['path' => 'css/login.css'],
                        ['path' => 'css/promo.css'],
                        ...Embeddables::getKodsegedStyles(),
                    ],
                    'scripts' => [
                        ...Embeddables::getKodsegedScripts(),
                    ],
                ]);
                return;
            }

            // waiting for ipn
            if (!$subscriberCourse->getIsVerified()) {

                echo $twig->render('wrapper.twig', [
                    'structuredData' => courseToStructuredData($course),
                    'content' => $twig->render('react-paywall.twig', [
                        'paywallForm' => $twig->render('paywall-form.twig', [
                            'subscriberCourse' => $subscriberCourse,
                            'course' => $course,
                            'isInvoice' => $subscriberCourse->getPurchaseType() === 'invoice',
                            'error' => $_GET['error'] ?? '',
                            'transactionSuccessful' => $_GET['transactionSuccessful'] ?? '',
                            'transactionId' => $_GET['transactionId'] ?? '',
                            'merchant' => $_GET['merchant'] ?? '',
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
                        ...Embeddables::getKodsegedStyles(),
                    ],
                    'scripts' => [
                        ...Embeddables::getKodsegedScripts(),
                    ],
                ]);
                return;
            }

            echo $twig->render('wrapper.twig', [
                'subscriberLabel' =>  getNick($request->vars),
                'structuredData' => courseToStructuredData($course),
                'content' => $twig->render('course.twig', [
                    'course' => $course,
                    'subscriberCourse' => $subscriberCourse,
                    'paddingTop' => true,
                    'episodes' => alignToRows($allEpisodesInCourse, 3),
                    'isSuccess' => $_GET['isSuccess'] ?? '',
                ]),
                'styles' => [
                    ['path' => 'css/promo.css'],
                ],
            ]);
        });

        $r->get(
            '/{course-slug}/{episode-slug}',
            $initSubscriberSession,
            Episodes::episodeSingleHandler($conn, $twig)
        );
    }
}

function courseToStructuredData($course)
{
    return json_encode([
        "@context" => "https://schema.org",
        "@type" => "Course",
        "name" => $course->getTitle() . ' kurzus KEZDŐ FEJLESZTŐKNEK',
        "description" => $course->getDescription(),
        "provider" => [
            "@type" => "Organization",
            "name" => "Kódbázis",
            "sameAs" => Router::siteUrl()
        ]
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

function renderEpisodeList($twig, $course, $allEpisodesInCourse)
{
    return $twig->render('course.twig', [
        'mainTitle' => 'Epizódok:',
        'isPromo' => true,
        'course' => $course,
        'episodes' => alignToRows($allEpisodesInCourse, 3),
    ]);
}

function getNick($vars)
{
    if (!isset($vars['subscriber'])) {
        return '';
    }

    return explode('@', $vars['subscriber']->getEmail())[0] ?? '';
}
