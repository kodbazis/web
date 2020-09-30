<?php

namespace Kodbazis;

use mysqli;
use Kodbazis\Generated\Repository\Embeddable\SqlByIdGetter;
use Kodbazis\Generated\Repository\Embeddable\SqlLister;
use Kodbazis\Generated\Repository\Course\SqlLister as CourseSqlLister;
use Kodbazis\Generated\Request;
use Kodbazis\Generated\Route\Embeddable\EmbeddableDeleter;
use Kodbazis\Generated\Route\Embeddable\EmbeddablePatcher;
use Kodbazis\Generated\Route\Embeddable\EmbeddableSaver;
use Kodbazis\Image\ImageSaver;
use Twig\Environment;
use Kodbazis\Generated\Repository\Embeddable\SqlByIdGetter as EmbeddableByIdGetter;

class Embeddables
{
    public static function getRoutes(Pipeline $r, mysqli $conn, Environment $twig)
    {

        $r->get(
            '/admin/beagyazhatok/letrehozas',
            [Router::class, 'setCsrfToken'],
            [Auth::class, 'validate'],
            function (Request $request) use ($conn, $twig) {
                $list = (new CourseSqlLister($conn))->list(Router::toQuery($request->query));

                header("Content-Type: text/html");
                $twig->display('dashboard.twig', [
                    'content' => 'embeddable-create.twig',
                    'activePath' => '/admin/beagyazhatok',
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
            '/admin/beagyazhatok',
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
                    'activePath' => '/admin/beagyazhatok',
                    'path' => $request->path,
                    'query' => $request->query,
                    'pagination' => Router::getPagination($request, $list->getCount()),
                    'actions' => Router::getActions('beagyazhatok'),
                    'columns' => [
                        ['label' => 'Id', 'key' => 'id'],
                        ['label' => 'Név', 'key' => 'name'],
                        ['label' => 'Típus', 'key' => 'type'],
                    ],
                ]);
            }
        );
        $r->get(
            '/admin/beagyazhatok/megtekintes/{id}',
            [Router::class, 'setCsrfToken'],
            [Auth::class, 'validate'],
            function (Request $request) use ($conn, $twig) {


                $getFileExtension = fn ($fileName) => pathinfo($fileName)['extension'];

                $filterExtension = fn ($ext) => fn ($item) => $getFileExtension($item) === $ext;
                $codeAssistScripts = array_filter(scandir('../public/kodseged/js'), $filterExtension('js'));
                $codeAssistStyles = array_filter(scandir('../public/kodseged/css'), $filterExtension('css'));

                $codeAssistScriptPaths = array_map(fn ($item) => ['path' => "kodseged/js/$item"], $codeAssistScripts);
                $codeAssistStylePaths = array_map(fn ($item) => ['path' => "kodseged/css/$item"], $codeAssistStyles);

                header("Content-Type: text/html");
                $twig->display('dashboard.twig', [
                    'csrfToken' => $request->params['csrfToken'],
                    'mainLabel' => 'Beágyazható',
                    'content' => "embeddable-single.twig",
                    'embeddable' => self::toEmbedded('{{' . $request->vars['id'] .  '}}', $conn, $twig),
                    'activePath' => '/admin/beagyazhatok',
                    'scripts' => $codeAssistScriptPaths,
                    'styles' => $codeAssistStylePaths,
                ]);
            }
        );


        $r->get(
            '/admin/beagyazhatok/szerkesztes/{id:\d+}',
            [Router::class, 'setCsrfToken'],
            [Auth::class, 'validate'],
            function (Request $request) use ($conn, $twig) {
                header("Content-Type: text/html");
                $byId = (new SqlByIdGetter($conn))->byId($request->vars['id']);
                $twig->display('dashboard.twig', [
                    'content' => 'embeddable-edit.twig',
                    'embeddable' => array_merge([
                        'id' => $byId->getId(),
                        'name' => $byId->getName(),
                        'type' => $byId->getType(),
                    ], json_decode($byId->getRaw(), true)),
                    'activePath' => '/admin/beagyazhatok',
                    'csrfToken' => $request->params['csrfToken'],
                    'scripts' => [
                        ['path' => 'ckeditor/ckeditor.js'],
                        ['path' => 'js/Embeddable-create.js'],
                    ],
                ]);
            }
        );

        $r->post(
            '/admin/beagyazhatok/create',
            [Router::class, 'validateCsrfToken'],
            [Auth::class, 'validate'],
            function (Request $request) use ($conn, $twig) {
                if ($request->body['type'] === 'codeAssistant') {
                    $request->body = [
                        'name' => $request->body['name'],
                        'type' => $request->body['type'],
                        'raw' => json_encode([
                            'filechangesName' => $request->body['filechangesName'],
                            'videoFileName' => $request->body['videoFileName'],
                        ])
                    ];
                }
                if ($request->body['type'] === 'codeAssistantGif') {
                    $request->body = [
                        'name' => $request->body['name'],
                        'type' => $request->body['type'],
                        'raw' => json_encode([
                            'filechangesName' => $request->body['filechangesName'],
                            'fileName' => $request->body['fileName'],
                            'showFrameNumber' => isset($request->body['showFrameNumber']),
                            'layout' => $request->body['layout'],
                        ])
                    ];
                }
                if ($request->body['type'] === 'codeAssistantYoutube') {
                    $request->body = [
                        'name' => $request->body['name'],
                        'type' => $request->body['type'],
                        'raw' => json_encode([
                            'filechangesName' => $request->body['filechangesName'],
                            'videoId' => $request->body['videoId'],
                        ])
                    ];
                }

                if ($request->body['type'] === 'youtube') {
                    $request->body = [
                        'name' => $request->body['name'],
                        'type' => $request->body['type'],
                        'raw' => json_encode([
                            'videoId' => $request->body['videoId']
                        ])
                    ];
                }
                if ($request->body['type'] === 'gif') {
                    $request->body = [
                        'name' => $request->body['name'],
                        'type' => $request->body['type'],
                        'raw' => json_encode([
                            'fileName' => $request->body['fileName'],
                        ])
                    ];
                }

                (new EmbeddableSaver())->getRoute($request);
                header('Location: /admin/beagyazhatok?isSuccess=1');
            }
        );

        $r->post(
            '/admin/beagyazhatok/delete/{id:\d+}',
            [Router::class, 'validateCsrfToken'],
            [Auth::class, 'validate'],
            function (Request $request) use ($conn, $twig) {
                (new EmbeddableDeleter())->getRoute($request);
                $location = 'Location: /admin/beagyazhatok?from=' . ($request->query['from'] ? $request->query['from'] : 0)
                    . '&limit=' . ($request->query['limit'] ? $request->query['limit'] : 15) . '&isSuccess=1';
                header($location);
            }
        );

        $r->post(
            '/admin/beagyazhatok/update/{id:\d+}',
            [Router::class, 'validateCsrfToken'],
            [Auth::class, 'validate'],

            function (Request $request) use ($conn, $twig) {
                if ($request->body['type'] === 'codeAssistant') {
                    $request->body['raw'] = json_encode([
                        'filechangesName' => $request->body['filechangesName'],
                        'videoFileName' => $request->body['videoFileName'],
                    ]);
                }
                if ($request->body['type'] === 'codeAssistantYoutube') {
                    $request->body['raw'] = json_encode([
                        'filechangesName' => $request->body['filechangesName'],
                        'videoId' => $request->body['videoId'],
                    ]);
                }

                if ($request->body['type'] === 'youtube') {
                    $request->body['raw'] = json_encode([
                        'videoId' => $request->body['videoId']
                    ]);
                }
                if ($request->body['type'] === 'gif') {
                    $request->body['raw'] = json_encode([
                        'fileName' => $request->body['fileName'],
                    ]);
                }

                if ($request->body['type'] === 'codeAssistantGif') {
                    $request->body['raw'] = json_encode([
                        'filechangesName' => $request->body['filechangesName'],
                        'fileName' => $request->body['fileName'],
                        'showFrameNumber' => isset($request->body['showFrameNumber']),
                        'layout' => $request->body['layout'],
                    ]);
                }

                (new EmbeddablePatcher())->getRoute($request);
                header('Location: /admin/beagyazhatok?isSuccess=1');
            }
        );
    }
    public static function toEmbedded($content, $conn, $twig)
    {
        $matches = [];
        $pattern = '{{([0-9]+)}}';
        preg_match_all($pattern, $content, $matches);

        $ret = [];
        foreach ($matches[1] as $id) {
            $byId = (new EmbeddableByIdGetter($conn))->byId($id);
            if (!$byId) {
                continue;
            }

            $raw = json_decode($byId->getRaw(), true);
            $ret[] = ['id' => $id, 'content' => $twig->render('embeddable-content.twig', array_merge($raw, ['id' => $id, 'type' => $byId->getType()]))];
        }
        foreach ($ret as $item) {
            $content = str_replace(
                "{{" . $item['id'] . "}}",
                $item['content'],
                $content
            );
        }
        return $content;
    }
}
