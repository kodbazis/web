<?php

namespace Kodbazis;

use Kodbazis\Generated\Request;
use mysqli;
use Twig\Environment;

class ExampleApis
{

    public static function getRoutes(Pipeline $r, mysqli $conn, Environment $twig)
    {

        header("Access-Control-Allow-Origin:" . ($_SERVER['HTTP_ORIGIN'] ?? '*'));
        header("Access-Control-Allow-Credentials: true");
        $folder = __DIR__ . "/example-repos/instruments";
        $imagefileName = __DIR__ . '/example-repos/instruments.json';

        $getFileName = function ($folder) use ($imagefileName) {
            if (isset($_COOKIE['instrumentAPIID']) && @file_get_contents($folder . '/' . $_COOKIE['instrumentAPIID'] . '.json')) {
                return $_COOKIE['instrumentAPIID'] . '.json';
            }

            $id = uniqid();

            setcookie('instrumentAPIID', $id, [
                'expires' => time() + 60 * 60 * 24,
                'secure' => true,
                'samesite' => 'None',
            ]);
            $fileName = $id . '.json';
            copy($imagefileName,  $folder . '/' .  $fileName);
            return $fileName;
        };

        $getContent = function ($folder) use ($imagefileName) {
            $content = '';
            if (isset($_COOKIE['instrumentAPIID']) && @file_get_contents($folder . '/' . $_COOKIE['instrumentAPIID'] . '.json')) {
                $fileName = $_COOKIE['instrumentAPIID'] . '.json';
                $content = file_get_contents($folder . '/' .  $fileName);
            } else {
                $content = file_get_contents($imagefileName);
            }
            return $content;
        };

        $r->get('/api/instruments', function (Request $request) use ($folder, $getContent) {
            header('Content-Type: application/json');
            echo $getContent($folder);
        });

        $r->post('/api/prune-instruments', function (Request $request) use ($folder) {
            header('Content-Type: application/json');
            if (($request->query['key'] ?? 0) !== ($_SERVER['MASTER_PW'] ?? 1)) {
                http_response_code(401);
                echo json_encode(['error' => 'unauthorized']);
                return;
            }
            array_map('unlink', glob("$folder/*.*"));
            rmdir($folder);
            echo json_encode(['success' => true]);
        });

        $r->get('/api/instruments/{id}', function (Request $request) use ($folder, $getContent) {
            header('Content-Type: application/json');

            $instruments = json_decode($getContent($folder), true);
            $byId = array_values(array_filter($instruments, fn ($instrument) => $instrument['id'] === $request->vars['id']));
            if (isset($byId[0])) {
                return json_encode($byId[0]);
            } else {
                http_response_code(404);
                return json_encode(['error' => 'not found']);
            }
        });

        $r->post('/api/instruments', function (Request $request) use ($folder, $getFileName) {
            header('Content-Type: application/json');

            createPath($folder);
            $fileName = $getFileName($folder);

            $content = file_get_contents($folder . '/' .  $fileName);
            $instruments = json_decode($content, true);
            if (count($instruments) > 100) {
                http_response_code(400);
                echo ['error' => 'max size exceeded'];
                return;
            }

            $newItem = [
                'id' => uniqid(),
                'name' => filter_var((string)$request->body['name'], FILTER_SANITIZE_STRING),
                'price' => (int)$request->body['price'],
                'quantity' => (int)$request->body['quantity'],
                'imageURL' => filter_var((string)$request->body['imageURL'], FILTER_SANITIZE_STRING),
            ];
            $instruments[] = $newItem;
            file_put_contents($folder . '/' .  $fileName, json_encode($instruments));
            echo json_encode($newItem);
        });

        $r->put('/api/instruments/{id}', function (Request $request) use ($folder, $getFileName) {
            header('Content-Type: application/json');

            createPath($folder);
            $fileName = $getFileName($folder);

            $content = file_get_contents($folder . '/' .  $fileName);
            $instruments = json_decode($content, true);

            $index = findIndex($instruments, fn ($instrument) => $instrument['id'] === $request->vars['id']);

            if ($index === -1) {
                http_response_code(404);
                return json_encode(['error' => 'not found']);
            }

            $newItem = [
                'id' => $instruments[$index]['id'],
                'name' => filter_var((string)$request->body['name'], FILTER_SANITIZE_STRING),
                'price' => (int)$request->body['price'],
                'quantity' => (int)$request->body['quantity'],
                'imageURL' => filter_var((string)$request->body['imageURL'], FILTER_SANITIZE_STRING),
            ];
            $instruments[$index] = $newItem;
            file_put_contents($folder . '/' .  $fileName, json_encode($instruments));
            echo json_encode($newItem);
        });

        $r->delete('/api/instruments/{id}', function (Request $request) use ($folder, $getFileName) {
            header('Content-Type: application/json');

            createPath($folder);
            $fileName = $getFileName($folder);

            $content = file_get_contents($folder . '/' .  $fileName);
            $instruments = json_decode($content, true);

            $index = findIndex($instruments, fn ($instrument) => $instrument['id'] === $request->vars['id']);

            if ($index === -1) {
                http_response_code(404);
                return json_encode(['error' => 'not found']);
            }

            array_splice($instruments, $index, 1);
            file_put_contents($folder . '/' .  $fileName, json_encode($instruments));
            echo json_encode(['id' => $request->vars['id']]);
        });
    }
}


function findIndex($elements, $fn)
{
    $ret = -1;
    foreach ($elements as $i => $element) {
        if ($fn($element)) {
            return $i;
        }
    }
    return $ret;
}

function createPath($path)
{
    if (is_dir($path)) {
        return true;
    };
    $prevPath = substr($path, 0, strrpos($path, '/', -2) + 1);
    $return = createPath($prevPath);
    return ($return && is_writable($prevPath)) ? mkdir($path) : false;
}
