<?php

namespace Kodbazis;

use mysqli;
use Kodbazis\Generated\Repository\Episode\SqlByIdGetter;
use Kodbazis\Generated\Repository\Episode\SqlLister;
use Kodbazis\Generated\Repository\Course\SqlLister as CourseSqlLister;
use Kodbazis\Generated\Request;
use Kodbazis\Generated\Route\Episode\EpisodeDeleter;
use Kodbazis\Generated\Route\Episode\EpisodePatcher;
use Kodbazis\Generated\Route\Episode\EpisodeSaver;
use Kodbazis\Image\ImageSaver;
use Twig\Environment;
use Kodbazis\Generated\Repository\Course\SqlLister as CourseLister;
use Kodbazis\Generated\Repository\Episode\SqlLister as EpisodeLister;


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
                        ['label' => '#', 'key' => 'id'],
                        ['label' => 'Cím', 'key' => 'title'],
                        ['label' => 'Aktív', 'key' => 'isActive', 'type' => 'bool'],
                        ['label' => 'Készült', 'key' => 'createdAt', 'type' => 'timestamp'],
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
                header('Location: /admin/epizodok?isSuccess=1');
            }
        );
    }

    public static function episodeSingleHandler($conn, $twig)
    {
        return function (Request $request) use ($conn, $twig) {


            $bySlug = (new EpisodeLister($conn))->list(Router::where('slug', 'eq', $request->vars['episode-slug']))->getEntities();


            if (!isset($bySlug[0])) {
                header('Content-Type: text/html; charset=UTF-8');
                echo $twig->render('wrapper.twig', ['content' => '404.twig']);
                exit;
            }

            $post = $bySlug[0];

            header('Content-Type: text/html; charset=UTF-8');
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
                $dirName = json_decode($app->getRaw(), true)['directoryName'];
                $codeAssistScripts2 = array_filter(scandir('../public/app/' . $dirName), $filterExtension('css'));
                return array_map(fn ($item) => ['path' => "app/" . $dirName . "/$item"], $codeAssistScripts2);
            }, $apps);
            $appScripts = array_map(function ($app) use ($filterExtension) {
                $dirName = json_decode($app->getRaw(), true)['directoryName'];
                $codeAssistScripts2 = array_filter(scandir('../public/app/' . $dirName), $filterExtension('js'));
                return array_map(fn ($item) => ['path' => "app/" . $dirName . "/$item"], $codeAssistScripts2);
            }, $apps);

            echo $twig->render('wrapper.twig', [
                'title' => $post->getTitle(),
                'description' => $post->getDescription(),
                'post' => $post,
                'postContent' => $content,
                'content' => 'post-single.twig',
                'url' => Router::siteUrl() . $_SERVER['REQUEST_URI'],
                'scripts' => array_merge($codeAssistScriptPaths, ...$appScripts),
                'styles' => array_merge([
                    ['path' => 'css/post-single.css'],
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
