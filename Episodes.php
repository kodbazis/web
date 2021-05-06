<?php

namespace Kodbazis;


use Kodbazis\Generated\Listing\Clause;
use Kodbazis\Generated\Listing\Filter;
use Kodbazis\Generated\Listing\OrderBy;
use Kodbazis\Generated\Listing\Query;
use mysqli;
use Kodbazis\Generated\Repository\Episode\SqlByIdGetter;
use Kodbazis\Generated\Repository\Episode\SqlLister;
use Kodbazis\Generated\Repository\Course\SqlLister as CourseSqlLister;
use Kodbazis\Generated\Repository\Course\SqlByIdGetter as CourseById;
use Kodbazis\Generated\Request;
use Kodbazis\Generated\Route\Episode\EpisodeDeleter;
use Kodbazis\Generated\Route\Episode\EpisodePatcher;
use Kodbazis\Generated\Route\Episode\EpisodeSaver;
use Kodbazis\Image\ImageSaver;
use Twig\Environment;
use Kodbazis\Generated\Repository\Episode\SqlLister as EpisodeLister;
use Kodbazis\Generated\Repository\SubscriberCourse\SqlLister as SubscriberCourseLister;
use Kodbazis\Generated\Repository\Course\SqlLister as CourseLister;


class Episodes
{
    public static function getRoutes(Pipeline $r, mysqli $conn, Environment $twig)
    {

        $r->get(
            '/admin/epizodok/letrehozas',
            [Router::class, 'setCsrfToken'],
            [Auth::class, 'validate'],
            function (Request $request) use ($conn, $twig) {
                $list = (new CourseSqlLister($conn))->list(Router::toQuery($request->query));

                header("Content-Type: text/html");
                $twig->display('dashboard.twig', [
                    'content' => 'episode-create.twig',
                    'activePath' => '/admin/epizodok',
                    'courses' => $list->getEntities(),
                    'csrfToken' => $request->params['csrfToken'],
                    'scripts' => [
                        ['path' => 'ckeditor/ckeditor.js'],
                        ['path' => 'js/ckeditor-init.js'],
                    ],
                ]);
            }
        );


        $r->get(
            '/admin/epizodok',
            [Router::class, 'setCsrfToken'],
            [Auth::class, 'validate'],
            function (Request $request) use ($conn, $twig) {
                $list = (new SqlLister($conn))->list(Router::toQuery($request->query));

                header("Content-Type: text/html");
                $twig->display('dashboard.twig', [
                    'csrfToken' => $request->params['csrfToken'],
                    'entities' => $list->getEntities(),
                    'mainLabel' => 'Epizódok',
                    'content' => 'entity-list.twig',
                    'activePath' => '/admin/epizodok',
                    'path' => $request->path,
                    'query' => $request->query,
                    'pagination' => Router::getPagination($request, $list->getCount()),
                    'actions' => Router::getActions('epizodok'),
                    'columns' => [
                        ['label' => 'Cím', 'key' => 'title'],
                        ['label' => 'Aktív', 'key' => 'isActive', 'type' => 'bool'],
                        ['label' => 'Bemutató', 'key' => 'isPreview', 'type' => 'bool'],
                        ['label' => 'Készült', 'key' => 'createdAt', 'type' => 'timestamp'],
                        ['label' => 'Pozíció', 'key' => 'position', 'type' => 'number'],
                    ],
                ]);
            }
        );


        $r->get(
            '/admin/epizodok/szerkesztes/{id:\d+}',
            [Router::class, 'setCsrfToken'],
            [Auth::class, 'validate'],
            function (Request $request) use ($conn, $twig) {
                header("Content-Type: text/html");

                $byId = (new SqlByIdGetter($conn))->byId($request->vars['id']);
                $twig->display('dashboard.twig', [
                    'content' => 'episode-edit.twig',
                    'episode' => $byId,
                    'activePath' => '/admin/epizodok',
                    'csrfToken' => $request->params['csrfToken'],
                    'scripts' => [
                        ['path' => 'ckeditor/ckeditor.js'],
                        ['path' => 'js/ckeditor-init.js'],
                    ],
                ]);
            }
        );

        $r->get(
            '/admin/epizodok/megtekintes/{episode-slug}',
            [Router::class, 'setCsrfToken'],
            [Auth::class, 'validate'],
            Episodes::episodeSingleHandler($conn, $twig),
        );

        $r->post(
            '/admin/epizodok/create',
            [Router::class, 'validateCsrfToken'],
            [Auth::class, 'validate'],
            [ImageSaver::class, 'getRoute'],
            function (Request $request) use ($conn, $twig) {
                if ($request->files['mainImage']['tmp_name']) {
                    $request->body['imgUrl'] = $request->vars['savedFiles']['mainImage'];
                }

                $request->body['slug'] = (new Slugifier($conn))->slugify('episodes', $request->body['title']);
                (new EpisodeSaver())->getRoute($request);
                header('Location: /admin/epizodok?isSuccess=1');
            }
        );

        $r->post(
            '/admin/epizodok/delete/{id:\d+}',
            [Router::class, 'validateCsrfToken'],
            [Auth::class, 'validate'],
            function (Request $request) use ($conn, $twig) {
                (new EpisodeDeleter())->getRoute($request);
                $location = 'Location: /admin/epizodok?from=' . ($request->query['from'] ? $request->query['from'] : 0)
                    . '&limit=' . ($request->query['limit'] ? $request->query['limit'] : 15) . '&isSuccess=1';
                header($location);
            }
        );

        $r->post(
            '/admin/epizodok/update/{id:\d+}',
            [Router::class, 'validateCsrfToken'],
            [Auth::class, 'validate'],
            [ImageSaver::class, 'getRoute'],
            function (Request $request) use ($conn, $twig) {

                if ($request->files['mainImage']['tmp_name']) {
                    $request->body['imgUrl'] = $request->vars['savedFiles']['mainImage'];
                }

                (new EpisodePatcher())->getRoute($request);
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        );
    }


    public static function episodeSingleHandler($conn, $twig)
    {
        return function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');

            $bySlug = (new EpisodeLister($conn))->list(Router::where('slug', 'eq', $request->vars['episode-slug']))->getEntities();

            $episode = $bySlug[0] ?? null;

            if (!$episode) {
                http_response_code(404);
                echo $twig->render('404.twig');
                return;
            }


            if (!isset($_SESSION['subscriberId']) && !$episode->getIsPreview()) {
                $course = (new CourseById($conn))->byId($episode->getCourseId());
                echo self::denyEpisode($twig, $episode, $request, $twig->render('denied-episode.twig', [
                    'course' => $course,
                    'episode' => $episode,
                    'isLogin' => isset($_GET['isLogin']),
                    'error' => $_GET['error'] ?? '0',
                    'registrationEmailSent' => isset($_GET['registrationEmailSent']),
                    'isPasswordModificationSuccess' => isset($_GET['isPasswordModificationSuccess']),
                ]));
                return;
            }

            if (!$episode->getIsPreview()) {
                $subscriberCourses = (new SubscriberCourseLister($conn))->list(new Query(
                    1000,
                    0,
                    new Filter(
                        'and',
                        new Clause('eq', 'subscriberId', $_SESSION['subscriberId'] ?? ''),
                        new Clause('eq', 'courseId', $episode->getCourseId()),
                    ),
                    new OrderBy('id', 'asc')
                ));

                if (!$subscriberCourses->getCount()) {
                    $courseBySlug = (new CourseLister($conn))->list(Router::where('slug', 'eq', $request->vars['course-slug']));
                    $course = $courseBySlug->getEntities()[0] ?? null;
                    header('Location: /' . $course->getSlug());
                    return;
                }
                $subscriberCourse = $subscriberCourses->getEntities()[0];

                if (!$subscriberCourse->getIsVerified()) {
                    $courseBySlug = (new CourseLister($conn))->list(Router::where('slug', 'eq', $request->vars['course-slug']));
                    $course = $courseBySlug->getEntities()[0] ?? null;
                    header('Location: /' . $course->getSlug());
                    return;
                }
            }

            $query = new Query(
                1000,
                0,
                new Filter(
                    'and',
                    new Clause('eq', 'courseId', $episode->getCourseId()),
                    new Clause('eq', 'isActive', 1),
                ),
                new OrderBy('position', 'asc')
            );

            $allEpisodesInCourse = (new EpisodeLister($conn))->list($query)->getEntities();

            $ids = Embeddables::getIds($episode->getContent());
            $embeddables = count($ids) ? Embeddables::getEmbeddables($ids, $conn) : [];
            $templates = Embeddables::mapEmbeddablesToTemplates($embeddables, $twig);
            $content = Embeddables::insertEmbeddablesToContent($templates, $episode->getContent());

            $episodeIndex = null;
            foreach ($allEpisodesInCourse as $i => $ep) {
                if ($ep->getPosition() !== $episode->getPosition()) {
                    continue;
                }
                $episodeIndex = $i;
                break;
            }


            $subscriberCourses = (new SubscriberCourseLister($conn))->list(new Query(
                1000,
                0,
                new Filter(
                    'and',
                    new Filter(
                        'and',
                        new Clause('eq', 'subscriberId', $_SESSION['subscriberId'] ?? ''),
                        new Clause('eq', 'courseId', $episode->getCourseId()),
                    ),
                    new Clause('eq', 'isVerified', '1'),
                ),
                new OrderBy('id', 'asc')
            ));

            $course = (new CourseById($conn))->byId($episode->getCourseId());

            $recommendedCourses = (new CourseSqlLister($conn))->list(new Query(
                1000,
                0,
                new Clause('nin', 'id', [$episode->getCourseId()]),
                new OrderBy('id', 'asc')
            ));

            $apps = array_filter($embeddables, fn ($em) => $em->getType() === 'application');
            echo $twig->render('wrapper.twig', [
                'title' => $episode->getTitle(),
                'description' => $episode->getDescription(),
                'subscriberLabel' =>  getNick($request->vars),
                'email' => $_GET['email'] ?? '',
                'content' => $twig->render('episode-single.twig', [
                    'recommendedCourses' => $recommendedCourses->getEntities(),
                    'isVerified' => (bool)$subscriberCourses->getCount(),
                    'course' => $course,
                    'isLoggedIn' => isset($_SESSION['subscriberId']),
                    'loginError' => $_GET['loginError'] ?? '0',
                    'episode' => $episode,
                    'episodeContent' => $content,
                    'allEpisodesInCourse' => $allEpisodesInCourse,
                    'nextEpisode' => $allEpisodesInCourse[$episodeIndex + 1] ?? null,
                    'previousEpisode' => $allEpisodesInCourse[$episodeIndex - 1] ?? null,
                    'url' => Router::siteUrl() . parse_url(Router::siteUrl() . $_SERVER['REQUEST_URI'])['path'],
                ]),
                'scripts' => [
                    ...Embeddables::getKodsegedScripts(),
                    ...Embeddables::getAppScripts($apps),
                ],
                'styles' => [
                    ['path' => 'css/promo.css'],
                    ['path' => 'css/post-single.css'],
                    ['path' => 'css/episode-single.css'],
                    ['path' => 'css/fonts/fontawesome/css/fontawesome-all.css'],
                    ...Embeddables::getKodsegedStyles(),
                    ...Embeddables::getAppStyles($apps),
                ],
                'ogTags' => getEpisodeOgTags($episode),
            ]);
        };
    }

    private static function denyEpisode($twig, $episode, $request, $content)
    {
        return $twig->render('wrapper.twig', [
            'title' => $episode->getTitle(),
            'description' => $episode->getDescription(),
            'subscriberLabel' =>  getNick($request->vars),
            'email' => $_GET['email'] ?? '',
            'content' => $content,
            'scripts' => [
                ...Embeddables::getKodsegedScripts(),
            ],

            'styles' => [
                ['path' => 'css/login.css'],
                ['path' => 'css/promo.css'],
                ['path' => 'css/post-single.css'],
                ['path' => 'css/episode-single.css'],
                ...Embeddables::getKodsegedStyles(),
            ],
            'ogTags' => getEpisodeOgTags($episode),
        ]);
        return;
    }
}

function getEpisodeOgTags($episode)
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
            'content' => $episode->getTitle(),
        ],
        [
            'property' => 'og:image',
            'content' => Router::siteUrl() . '/public/files/md-' . $episode->getImgUrl(),
        ],
        [
            'property' => 'og:description',
            'content' => $episode->getDescription(),
        ],
        [
            'property' => 'fb:app_id',
            'content' => '705894336804251',
        ],
    ];
}
