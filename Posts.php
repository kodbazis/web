<?php

namespace Kodbazis;

use Kodbazis\Generated\Listing\OrderBy;
use Kodbazis\Generated\Listing\Query;
use mysqli;
use Kodbazis\Generated\Repository\Post\SqlByIdGetter;

use Kodbazis\Generated\Repository\Post\SqlLister;
use Kodbazis\Generated\Request;
use Kodbazis\Generated\Route\Post\PostDeleter;
use Kodbazis\Generated\Route\Post\PostPatcher;
use Kodbazis\Generated\Route\Post\PostSaver;
use Kodbazis\Generated\Repository\Course\SqlLister as CourseSqlLister;
use Kodbazis\Image\ImageSaver;
use Twig\Environment;

class Posts
{
    const rootPath = '/admin';

    public static function getRoutes(Pipeline $r, mysqli $conn, Environment $twig)
    {
        $r->get(
            '/admin/cikkek/megtekintes/{slug}',
            [Auth::class, 'validate'],
            self::postSingleHandler($conn, $twig)
        );

        $r->get(
            '/admin/cikkek/letrehozas',
            [Router::class, 'setCsrfToken'],
            [Auth::class, 'validate'],
            function (Request $request) use ($conn, $twig) {
                header("Content-Type: text/html");
                $twig->display('dashboard.twig', [
                    'content' => 'post-create.twig',
                    'activePath' => self::rootPath,
                    'csrfToken' => $request->params['csrfToken'],
                    'scripts' => [
                        ['path' => 'ckeditor/ckeditor.js'],
                        ['path' => 'js/ckeditor-init.js'],
                    ],
                ]);
            }
        );


        $r->get(
            '/admin',
            [Router::class, 'setCsrfToken'],
            [Auth::class, 'validate'],
            function (Request $request) use ($conn, $twig) {
                $list = (new SqlLister($conn))->list(Router::toQuery($request->query));

                header("Content-Type: text/html");
                $twig->display('dashboard.twig', [
                    'csrfToken' => $request->params['csrfToken'],
                    'entities' => $list->getEntities(),
                    'mainLabel' => 'Cikkek',
                    'content' => 'post-list.twig',
                    'activePath' => self::rootPath,
                    'path' => $request->path,
                    'query' => $request->query,
                    'pagination' => Router::getPagination($request, $list->getCount()),
                    'actions' => Router::getActions('cikkek'),
                    'columns' => [
                        ['label' => '#', 'key' => 'id'],
                        ['label' => 'Cím', 'key' => 'title'],
                        ['label' => 'Aktív', 'key' => 'isActive', 'type' => 'bool'],
                        ['label' => 'Készült', 'key' => 'createdAt', 'type' => 'timestamp'],
                    ],
                ]);
            }
        );


        $r->get(
            '/admin/cikkek/szerkesztes/{id:\d+}',
            [Router::class, 'setCsrfToken'],
            [Auth::class, 'validate'],
            function (Request $request) use ($conn, $twig) {
                header("Content-Type: text/html");

                $byId = (new SqlByIdGetter($conn))->byId($request->vars['id']);
                $twig->display('dashboard.twig', [
                    'content' => 'post-edit.twig',
                    'post' => $byId,
                    'activePath' => self::rootPath,
                    'csrfToken' => $request->params['csrfToken'],
                    'scripts' => [
                        ['path' => 'ckeditor/ckeditor.js'],
                        ['path' => 'js/ckeditor-init.js'],
                    ],
                ]);
            }
        );

        $r->post(
            '/admin/cikkek/create',
            [Router::class, 'validateCsrfToken'],
            [Auth::class, 'validate'],
            [ImageSaver::class, 'getRoute'],
            function (Request $request) use ($conn, $twig) {
                if ($request->files['mainImage']['tmp_name']) {
                    $request->body['imgUrl'] = $request->vars['savedFiles']['mainImage'];
                }

                $request->body['slug'] = (new Slugifier($conn))->slugify('posts', $request->body['title']);
                @$request->body['publishedAt'] = $request->body['publishedAt'] ? $request->body['publishedAt'] : time();
                (new PostSaver())->getRoute($request);
                header('Location: ' . self::rootPath . '?isSuccess=1');
            }
        );

        $r->post(
            '/admin/cikkek/delete/{id:\d+}',
            [Router::class, 'validateCsrfToken'],
            [Auth::class, 'validate'],
            function (Request $request) use ($conn, $twig) {
                (new PostDeleter())->getRoute($request);
                $location = 'Location: ' . self::rootPath . '?from=' . ($request->query['from'] ? $request->query['from'] : 0)
                    . '&limit=' . ($request->query['limit'] ? $request->query['limit'] : 15) . '&isSuccess=1';
                header($location);
            }
        );

        $r->post(
            '/admin/cikkek/update/{id:\d+}',
            [Router::class, 'validateCsrfToken'],
            [Auth::class, 'validate'],
            [ImageSaver::class, 'getRoute'],
            function (Request $request) use ($conn, $twig) {

                // if (isset($request->body['slug'])) {
                //     $request->body['slug'] = (new Slugifier($conn))->slugify('posts', $request->body['slug']);
                // }

                if ($request->files['mainImage']['tmp_name']) {
                    $request->body['imgUrl'] = $request->vars['savedFiles']['mainImage'];
                }

                (new PostPatcher())->getRoute($request);
                header('Location: ' . self::rootPath . '?isSuccess=1');
            }
        );
    }

    public static function postSingleHandler($conn, $twig)
    {
        return function (Request $request) use ($conn, $twig) {

            header('Content-Type: text/html; charset=UTF-8');

            $bySlug = (new SqlLister($conn))->list(Router::where('slug', 'eq', $request->vars['slug']));

            if (!isset($bySlug->getEntities()[0])) {
                http_response_code(404);
                echo $twig->render('404.twig');
                return;
            }
            $post = $bySlug->getEntities()[0];

            $getFileExtension = fn ($fileName) => pathinfo($fileName)['extension'];

            $filterExtension = fn ($ext) => fn ($item) => $getFileExtension($item) === $ext;
            $codeAssistScripts = array_filter(scandir('../public/kodseged/js'), $filterExtension('js'));
            $codeAssistStyles = array_filter(scandir('../public/kodseged/css'), $filterExtension('css'));

            $codeAssistScriptPaths = array_map(fn ($item) => ['path' => "kodseged/js/$item"], $codeAssistScripts);
            $codeAssistStylePaths = array_map(fn ($item) => ['path' => "kodseged/css/$item"], $codeAssistStyles);

            $ids = Embeddables::getIds($post->getContent());
            $embeddables = count($ids) ? Embeddables::getEmbeddables($ids, $conn) : [];
            $templates = Embeddables::mapEmbeddablesToTemplates($embeddables, $twig);
            $content = Embeddables::insertEmbeddablesToContent($templates, $post->getContent());



            $apps = array_filter($embeddables, fn ($em) => $em->getType() === 'application');
            $appStyles = array_map(function ($app) use ($filterExtension) {
                $codeAssistScripts2 = array_filter(scandir('../public/app/' . $app->getName()), $filterExtension('css'));
                return array_map(fn ($item) => ['path' => "app/" . $app->getName() . "/$item"], $codeAssistScripts2);
            }, $apps);
            $appScripts = array_map(function ($app) use ($filterExtension) {
                $codeAssistScripts2 = array_filter(scandir('../public/app/' . $app->getName()), $filterExtension('js'));
                return array_map(fn ($item) => ['path' => "app/" . $app->getName() . "/$item"], $codeAssistScripts2);
            }, $apps);


            $recommendedCourses = (new CourseSqlLister($conn))->list(new Query(
                1000,
                0,
                null,
                new OrderBy('id', 'asc')
            ));

            echo $twig->render('wrapper.twig', [
                'title' => $post->getTitle(),
                'description' => $post->getDescription(),
                'structuredData' => json_encode([
                    "@context" => "https://schema.org",
                    "@type" => "NewsArticle",
                    "mainEntityOfPage" => [
                        "@type" => "WebPage",
                        "@id" => Router::siteUrl() . $_SERVER['REQUEST_URI']
                    ],
                    "headline" => $post->getTitle(),
                    "image" => [
                        Router::siteUrl() . '/public/files/md-' . $post->getImgUrl(),
                    ],
                    "datePublished" => date(\DateTime::ATOM, $post->getCreatedAt()),
                    "dateModified" => date(\DateTime::ATOM, $post->getCreatedAt() + 100),
                    "author" => [
                        "@type" => "Organization",
                        "name" => "Kódbázis"
                    ],
                    "publisher" => [
                        "@type" => "Organization",
                        "name" => "Kódbázis",
                        "logo" => [
                            "@type" => "ImageObject",
                            "url" => Router::siteUrl() . "/public/images/logo-dark.png",
                        ]
                    ]
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'subscriberLabel' =>  getNick($request->vars),
                'content' => $twig->render('post-single.twig', [
                    'post' => $post,
                    'postContent' => $content,
                    'url' => Router::siteUrl() . $_SERVER['REQUEST_URI'],
                    'recommendedCourses' => $recommendedCourses->getEntities(),
                ]),
                'scripts' => array_merge($codeAssistScriptPaths, ...$appScripts),
                'styles' => array_merge([
                    ['path' => 'css/post-single.css'],
                    ['path' => 'css/episode-single.css'],
                    ['path' => 'css/promo.css'],
                ], $codeAssistStylePaths, ...$appStyles),
                'ogTags' => [
                    [
                        'property' => 'og:url',
                        'content' => Router::siteUrl() . $_SERVER['REQUEST_URI'],
                    ],
                    [
                        'property' => 'og:type',
                        'content' => 'article',
                    ],
                    [
                        'property' => 'og:title',
                        'content' => $post->getTitle(),
                    ],
                    [
                        'property' => 'og:image',
                        'content' => Router::siteUrl() . '/public/files/md-' . $post->getImgUrl(),
                    ],
                    [
                        'property' => 'og:description',
                        'content' => $post->getDescription(),
                    ],
                    [
                        'property' => 'fb:app_id',
                        'content' => '705894336804251',
                    ],
                ]
            ]);
        };
    }
}
