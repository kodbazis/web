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
            '/admin/epizodok/epizod-szerkesztes/{id:\d+}',
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
                        ['path' => 'js/episode-create.js'],
                    ],
                ]);
            }
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
}
