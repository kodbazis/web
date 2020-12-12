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
use Kodbazis\Generated\Repository\Embeddable\SqlByIdGetter;
use Kodbazis\Generated\Repository\Course\SqlLister as CourseLister;
use Kodbazis\Generated\Repository\Episode\SqlLister as EpisodeLister;
use Kodbazis\Episodes;

class PublicSite
{
    public static function getRoutes(Pipeline $r, mysqli $conn, Environment $twig)
    {
        $r->get('/', function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');

            echo $twig->render('wrapper.twig', [
                'content' => 'home.twig',
                'scripts' => [
                    ['path' => 'js/jquery.js'],
                    ['path' => 'js/application.js'],
                ],

            ]);
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

        $r->get('/elerhetoseg', function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');

            echo $twig->render('wrapper.twig', [
                'content' => 'contact.twig',
                'description' => 'Elérhetőség'
            ]);
        });
        $r->get('/trening', function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');
            echo $twig->render('wrapper.twig', [
                'content' => 'training.twig',
                'description' => 'Személyre szabott tanítás JavaScript, React, Angular és PHP témákban.',
                'styles' => [
                    ['path' => 'css/bootstrap-datetimepicker.min.css'],
                    ['path' => 'css/application-form.css'],
                ],
                'scripts' => [
                    ['path' => 'js/jquery.js'],
                    ['path' => 'js/moment.js'],
                    ['path' => 'js/moment-timezone.js'],
                    ['path' => 'js/bootstrap-datetimepicker.min.js'],
                    ['path' => 'js/application-form.js'],
                ],
            ]);
        });

        $r->post('/apply-to-training', function (Request $request) use ($conn, $twig) {
            $msg = "Név: " . $request->body['name'] . "<br/>" .
                "Email: " . $request->body['email'] . "<br/>" .
                "Dátum: " . $request->body['date'] . "<br/>" .
                "Megjegyzések: " . $request->body['remarks'] . "<br/>";

            @(new Mailer())->sendMail('Új jelentkező: ' . $request->body['name'], $msg);
            echo json_encode(['message' => 'success']);
        });

        $r->get('/cikkek', function (Request $request) use ($conn, $twig) {

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
                'posts' => alignToRows($posts->getResults(), 3),
                'content' => 'posts.twig',
            ]);
        });

        $r->get('/adatvedelmi-szabalyzat', function (Request $request) use ($conn, $twig) {
            header('Content-Type: text/html; charset=UTF-8');
            echo $twig->render('wrapper.twig', [
                'content' => 'privacy-policy.html',
                'description' => 'A Kódbázis adatvédelmi szabályzata'
            ]);
        });

        $r->get('/react-kurzus', function (Request $request) use ($conn, $twig) {
            header('Location: /react-kurzus/a-react-filozofiaja');
        });

        $r->get('/kurzus/{slug}', function (Request $request) use ($conn, $twig) {
            $courseBySlug = (new CourseLister($conn))->list(Router::where('slug', 'eq', $request->vars['slug']));
            $course = $courseBySlug->getEntities()[0];
            if (!$course) {
                return;
            }
            $episodesByCourseId = (new EpisodeLister($conn))->list(Router::where('courseId', 'eq', $course->getId()))->getEntities();

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
                'content' => 'course.twig',
                'course' => $course,
                'episodes' => alignToRows($episodesByCourseId, 3),
            ]);
        });

        // $r->get('/react-kurzus', function (Request $request) use ($conn, $twig) {
        //     echo 'React kurzus';
        // });


        $r->get('/{course-slug}-kurzus/{episode-slug}', Episodes::episodeSingleHandler($conn, $twig));


        $r->get('/watch/{course-slug}/{episode-filename}', function (Request $request) use ($conn, $twig) {

            // read session -> userId
            // getUser(userId)
            // getCourse({course-slug})
            //if user.courses doesn't contain course.id
            // err

            // serve file
            $path = "../courses" . DIRECTORY_SEPARATOR . $request->vars['course-slug'] . DIRECTORY_SEPARATOR . $request->vars['episode-filename'];
            serveVideo($path);
        });

        function serveVideo($path)
        {
            $fp = fopen($path, "rb");

            if (!$fp) {
                return;
            }

            $size = filesize($path);
            $length = $size;
            $start = 0;
            $end = $size - 1;
            header('Content-type: video/mp4');
            header("Accept-Ranges: 0-$length");
            if (isset($_SERVER['HTTP_RANGE'])) {
                $c_start = $start;
                $c_end = $end;
                list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
                if (strpos($range, ',') !== false) {
                    header('HTTP/1.1 416 Requested Range Not Satisfiable');
                    header("Content-Range: bytes $start-$end/$size");
                    exit;
                }
                if ($range == '-') {
                    $c_start = $size - substr($range, 1);
                } else {
                    $range = explode('-', $range);
                    $c_start = $range[0];
                    $c_end = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $size;
                }
                $c_end = ($c_end > $end) ? $end : $c_end;
                if ($c_start > $c_end || $c_start > $size - 1 || $c_end >= $size) {
                    header('HTTP/1.1 416 Requested Range Not Satisfiable');
                    header("Content-Range: bytes $start-$end/$size");
                    exit;
                }
                $start = $c_start;
                $end = $c_end;
                $length = $end - $start + 1;
                fseek($fp, $start);
                header('HTTP/1.1 206 Partial Content');
            }
            header("Content-Range: bytes $start-$end/$size");
            header("Content-Length: " . $length);
            $buffer = 1024 * 8;
            while (!feof($fp) && ($p = ftell($fp)) <= $end) {
                if ($p + $buffer > $end) {
                    $buffer = $end - $p + 1;
                }
                set_time_limit(0);
                echo fread($fp, $buffer);
                flush();
            }
            fclose($fp);
            exit;
        }

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
        $r->get('/embeddable/codeAssistant/{id}/video', function (Request $request) use ($conn, $twig) {
            header('Access-Control-Allow-Origin: *');
            $item = (new SqlByIdGetter($conn))->byId($request->vars['id']);
            $raw = json_decode($item->getRaw(), true);
            $path = "../embeddable/codeAssistant/" . $raw['videoFileName'];
            serveVideo($path);
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

        $r->get('/cikkek/{slug}', Posts::postSingleHandler($conn, $twig));
    }
}
