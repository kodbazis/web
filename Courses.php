<?php

namespace Kodbazis;

use mysqli;
use Kodbazis\Generated\Repository\Course\SqlByIdGetter;
use Kodbazis\Generated\Repository\Course\SqlLister;
use Kodbazis\Generated\Request;
use Kodbazis\Generated\Route\Course\CourseDeleter;
use Kodbazis\Generated\Route\Course\CoursePatcher;
use Kodbazis\Generated\Route\Course\CourseSaver;
use Kodbazis\Image\ImageSaver;
use Twig\Environment;

class Courses
{
    public static function getRoutes(Pipeline $r, mysqli $conn, Environment $twig)
    {

        $r->get(
            '/admin/kurzusok/letrehozas',
            [Router::class, 'setCsrfToken'],
            [Auth::class, 'validate'],
            function (Request $request) use ($conn, $twig) {
                header("Content-Type: text/html");
                $twig->display('dashboard.twig', [
                    'content' => 'course-create.twig',
                    'activePath' => '/admin/kurzusok',
                    'csrfToken' => $request->params['csrfToken'],
                    'scripts' => [
                        ['path' => 'ckeditor/ckeditor.js'],
                        ['path' => 'js/ckeditor-init.js'],
                    ],
                ]);
            }
        );


        $r->get(
            '/admin/kurzusok',
            [Router::class, 'setCsrfToken'],
            [Auth::class, 'validate'],
            function (Request $request) use ($conn, $twig) {
                $list = (new SqlLister($conn))->list(Router::toQuery($request->query));

                header("Content-Type: text/html");
                $twig->display('dashboard.twig', [
                    'csrfToken' => $request->params['csrfToken'],
                    'entities' => $list->getEntities(),
                    'mainLabel' => 'Kurzusok',
                    'content' => 'entity-list.twig',
                    'activePath' => '/admin/kurzusok',
                    'path' => $request->path,
                    'query' => $request->query,
                    'pagination' => Router::getPagination($request, $list->getCount()),
                    'actions' => Router::getActions('kurzusok'),
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
            '/admin/kurzusok/szerkesztes/{id:\d+}',
            [Router::class, 'setCsrfToken'],
            [Auth::class, 'validate'],
            function (Request $request) use ($conn, $twig) {
                header("Content-Type: text/html");

                $byId = (new SqlByIdGetter($conn))->byId($request->vars['id']);
                $twig->display('dashboard.twig', [
                    'content' => 'course-edit.twig',
                    'course' => $byId,
                    'activePath' => '/admin/kurzusok',
                    'csrfToken' => $request->params['csrfToken'],
                    'scripts' => [
                        ['path' => 'ckeditor/ckeditor.js'],
                        ['path' => 'js/course-create.js'],
                    ],
                ]);
            }
        );

        $r->post(
            '/admin/kurzusok/create',
            [Router::class, 'validateCsrfToken'],
            [Auth::class, 'validate'],
            [ImageSaver::class, 'getRoute'],
            function (Request $request) use ($conn, $twig) {
                if ($request->files['mainImage']['tmp_name']) {
                    $request->body['imgUrl'] = $request->vars['savedFiles']['mainImage'];
                }

                $request->body['slug'] = (new Slugifier($conn))->slugify('courses', $request->body['title']);
                (new CourseSaver())->getRoute($request);
                header('Location: /admin/kurzusok?isSuccess=1');
            }
        );

        $r->post(
            '/admin/kurzusok/delete/{id:\d+}',
            [Router::class, 'validateCsrfToken'],
            [Auth::class, 'validate'],
            function (Request $request) use ($conn, $twig) {
                (new CourseDeleter())->getRoute($request);
                $location = 'Location: /admin/kurzusok?from=' . ($request->query['from'] ? $request->query['from'] : 0)
                    . '&limit=' . ($request->query['limit'] ? $request->query['limit'] : 15) . '&isSuccess=1';
                header($location);
            }
        );

        $r->post(
            '/admin/kurzusok/update/{id:\d+}',
            [Router::class, 'validateCsrfToken'],
            [Auth::class, 'validate'],
            [ImageSaver::class, 'getRoute'],
            function (Request $request) use ($conn, $twig) {

                if ($request->files['mainImage']['tmp_name']) {
                    $request->body['imgUrl'] = $request->vars['savedFiles']['mainImage'];
                }

                (new CoursePatcher())->getRoute($request);
                header('Location: /admin/kurzusok?isSuccess=1');
            }
        );
    }
}
