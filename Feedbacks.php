<?php

namespace Kodbazis;

use mysqli;
use Kodbazis\Generated\Repository\Feedback\SqlLister;
use Kodbazis\Generated\Request;
use Twig\Environment;

class Feedbacks
{
    public static function getRoutes(Pipeline $r, mysqli $conn, Environment $twig)
    {
        $r->get(
            '/admin/visszajelzesek',
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
                    'actions' => [],
                    'columns' => [
                        ['label' => 'Név', 'key' => 'name'],
                        ['label' => 'Tartalom', 'key' => 'content'],
                        ['label' => 'Epizód ID', 'key' => 'episodeId', 'type' => 'number'],
                        ['label' => 'Készült', 'key' => 'createdAt', 'type' => 'timestamp'],
                    ],
                ]);
            }
        );
    }
}
