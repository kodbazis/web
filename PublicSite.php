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
use Kodbazis\Generated\Repository\Episode\SqlLister as EpisodeLister;
use Kodbazis\Episodes;
use Kodbazis\Generated\Listing\Clause;
use Kodbazis\Generated\Listing\Filter;
use Kodbazis\Generated\Listing\OrderBy;
use Kodbazis\Generated\Listing\Query;
use Kodbazis\Generated\Subscriber\Patch\PatchedSubscriber;
use Kodbazis\Generated\Subscriber\Save\NewSubscriber;

class PublicSite
{

    public static function getRoutes(Pipeline $r, mysqli $conn, Environment $twig)
    {

        $initSubscriberSession = function (Request $request) use ($conn, $twig) {
            session_start();
            $subscriberEmail = '';
            if (isset($_SESSION['subscriberId'])) {
                $byId = (new SubscriberLister($conn))->list(Router::where('id', 'eq', $_SESSION['subscriberId']));
                if ($byId->getCount() > 0) {
                    $em = $byId->getEntities()[0]->getEmail();
                    $subscriberEmail = explode('@', $em)[0];
                }
            }
            $request->vars['subscriberLabel'] = $subscriberEmail;
            return $request;
        };




        $r->get('/', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');

            echo $twig->render('wrapper.twig', [
                'content' => $twig->render('home.twig', []),
                'subscriberLabel' =>  $request->vars['subscriberLabel'],
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

            if ($request->vars['subscriberLabel']) {
                header('Location: /');
                return;
            }

            echo $twig->render('wrapper.twig', [
                'content' => $twig->render('forgot-password.twig', [
                    'isError' => isset($_GET['isError']),
                    'emailSent' => isset($_GET['emailSent']),
                ]),
                'subscriberLabel' =>  $request->vars['subscriberLabel'],
                'styles' => [
                    ['path' => 'css/login.css']
                ],
            ]);
        });

        $r->post('/api/forgot-password', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');

            if ($request->vars['subscriberLabel']) {
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
                'subscriberLabel' =>  $request->vars['subscriberLabel'],
                'content' => $twig->render('subscriber-login.twig', [
                    'subscriberLabel' =>  $request->vars['subscriberLabel'],
                    'isLoggedIn' => isset($_SESSION['subscriberId']),
                    'isError' => isset($_GET['isError']),
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
                'subscriberLabel' =>  $request->vars['subscriberLabel'],
                'content' => $twig->render('subscriber-registration.twig', [
                    'isLoggedIn' => isset($_SESSION['subscriberId']),
                    'isSuccess' => isset($_GET['isSuccess']),
                    'isError' => $_GET['isError'] ?? '0',
                    'subscriberLabel' =>  $request->vars['subscriberLabel'],
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
                'subscriberLabel' =>  $request->vars['subscriberLabel'],
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

            $requestUri = parse_url($_SERVER['HTTP_REFERER'])['path'];

            if ($byEmail->getCount() === 0) {
                header('Location: ' .  $requestUri . "?isError=1&email=" . $request->body['email'] . "#subscriber-login");
                return;
            }

            $subscriber = $byEmail->getEntities()[0];
            if (!password_verify($request->body['password'], $subscriber->getPassword())) {
                header('Location: ' .  $requestUri . "?isError=1&email=" . $request->body['email'] . "#subscriber-login");
                return;
            }

            session_start();
            $_SESSION['subscriberId'] = $subscriber->getId();
            header('Location: /react-kurzus');
        });

        $r->get('/kodseged-kliens', function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');

            $getFileExtension = fn ($fileName) => pathinfo($fileName)['extension'];

            $filterExtension = fn ($ext) => fn ($item) => $getFileExtension($item) === $ext;
            $codeAssistScripts = array_filter(scandir('../public/kodseged/js'), $filterExtension('js'));
            $codeAssistStyles = array_filter(scandir('../public/kodseged/css'), $filterExtension('css'));

            $codeAssistScriptPaths = array_map(fn ($item) => ['path' => "kodseged/js/$item"], $codeAssistScripts);
            $codeAssistStylePaths = array_map(fn ($item) => ['path' => "kodseged/css/$item"], $codeAssistStyles);

            echo $twig->render('code-assistant-client.twig', [
                'scripts' => $codeAssistScriptPaths,
                'styles' => $codeAssistStylePaths,
            ]);
        });

        $r->get('/elerhetoseg', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');

            echo $twig->render('wrapper.twig', [
                'content' => $twig->render('contact.twig', []),
                'subscriberLabel' =>  $request->vars['subscriberLabel'],
                'description' => 'Elérhetőség'
            ]);
        });
        $r->get('/trening', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');
            echo $twig->render('wrapper.twig', [
                'content' => $twig->render('training.twig', []),
                'subscriberLabel' =>  $request->vars['subscriberLabel'],
                'description' => 'Személyre szabott tanítás JavaScript, React, Angular és PHP témákban.',
            ]);
        });

        $r->post('/api/request-membership', function (Request $request) use ($conn, $twig) {

            $byEmail = (new SubscriberLister($conn))->list(Router::where('email', 'eq', $request->body['email']));

            if ($byEmail->getCount() !== 0) {
                header('Location: /feliratkozas?isError=1');
                return;
            }

            if (!filter_var($request->body['email'], FILTER_VALIDATE_EMAIL)) {
                header('Location: /feliratkozas?isError=2');
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
                'link' => Router::siteUrl() . "/megerosites/" . $token,
            ]);
            @(new Mailer())->sendMail($request->body['email'], 'Megerősítés egyetlen kattintással', $msg);

            header('Location: /feliratkozas?isSuccess=1');
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
            header('Location: /react-kurzus?isSuccess=1');
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
                'subscriberLabel' =>  $request->vars['subscriberLabel'],
                'content' => $twig->render('posts.twig', [
                    'posts' => alignToRows($posts->getResults(), 3),
                ]),
            ]);
        });

        $r->get('/adatvedelmi-szabalyzat', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');
            echo $twig->render('wrapper.twig', [
                'content' => $twig->render('privacy-policy.html', []),
                'subscriberLabel' =>  $request->vars['subscriberLabel'],
                'description' => 'A Kódbázis adatvédelmi szabályzata'
            ]);
        });

        $r->get('/{course-slug}-kurzus', $initSubscriberSession, function (Request $request) use ($conn, $twig) {
            $courseBySlug = (new CourseLister($conn))->list(Router::where('slug', 'eq', $request->vars['course-slug']));
            $course = $courseBySlug->getEntities()[0] ?? null;

            if (!$course) {
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


            // is user subscribed
            // render more episodes
            // else
            // render subscription form

            header('Content-Type: text/html; charset=UTF-8');
            echo $twig->render('wrapper.twig', [
                'subscriberLabel' =>  $request->vars['subscriberLabel'],
                'structuredData' => json_encode([
                    "@context" => "https://schema.org",
                    "@type" => "Course",
                    "name" => $course->getTitle() . ' kurzus KEZDŐ FEJLESZTŐKNEK',
                    "description" => $course->getDescription(),
                    "provider" => [
                        "@type" => "Organization",
                        "name" => "Kódbázis",
                        "sameAs" => Router::siteUrl()
                    ]
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'content' => $twig->render('course.twig', [
                    'course' => $course,
                    'episodes' => alignToRows($allEpisodesInCourse, 3),
                ]),
            ]);
        });

        $r->get(
            '/{course-slug}-kurzus/{episode-slug}',
            $initSubscriberSession,
            Episodes::episodeSingleHandler($conn, $twig)
        );


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
    }
}
