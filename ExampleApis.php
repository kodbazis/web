<?php

namespace Kodbazis;

use Kodbazis\Generated\Request;
use mysqli;
use Twig\Environment;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Kodbazis\Generated\Auth\AccessToken;
use Kodbazis\Generated\Auth\AuthException;
use Kodbazis\Generated\Auth\RefreshToken;
use Kodbazis\Generated\Auth\Token;
use UnexpectedValueException;

class ExampleApis
{

    public static function getRoutes(Pipeline $r, mysqli $conn, Environment $twig)
    {
        self::registerInstrumentRoutes($r);
        self::registerAuthRoutes($r);
    }

    public static function  initLoginFile()
    {
        createPath(__DIR__ . '/example-repos/loggedInUsers');
        $path = __DIR__ . '/example-repos/loggedInUsers/loggedInUsers.json';
        if (file_exists($path)) {
            return;
        }

        file_put_contents($path, '{}');
    }


    public static function registerAuthRoutes($r)
    {



        $secret = "tokenSecret";
        $r->post('/api/login-user', function (Request $request) use ($secret) {
            header('Content-type: application/json');

            if ((($request->body['email'] ?? '') !== 'user@kodbazis.hu') || (($request->body['password'] ?? '') !== "teszt")) {
                http_response_code(401);
                throw new AuthException('missing token');
            }

            $id = uniqid();
            $access =  new AccessToken(JWT::encode([
                "sub" => $id,
                "iat" => time(),
                "exp" => time() + 10,
            ], $secret));

            $refresh = new RefreshToken(JWT::encode([
                "iat" => time(),
                'expires' => time() + 60 * 60 * 24 * 365,
            ], $secret));

            self::initLoginFile();
            $content = file_get_contents(__DIR__ . '/example-repos/loggedInUsers/loggedInUsers.json');
            $loggedInUsers = json_decode($content, true);
            $loggedInUsers[$id] = $refresh->getValue();
            file_put_contents(__DIR__ . '/example-repos/loggedInUsers/loggedInUsers.json', json_encode($loggedInUsers));
            echo json_encode(new Token($access, $refresh));
        });
        $r->post('/api/logout-user', function () use ($secret) {
            $headers = getallheaders();
            self::initLoginFile();
            $content = file_get_contents(__DIR__ . '/example-repos/loggedInUsers/loggedInUsers.json');
            $loggedInUsers = json_decode($content, true);

            try {
                $headers = getallheaders();
                if (!preg_match('/Bearer\s(\S+)/', $headers['Authorization'] ?? '', $matches)) {
                    throw new AuthException('missing token');
                }
                $decoded = JWT::decode($matches[1], $secret, ['HS256']);
                $id = $decoded->sub;
                if (!isset($loggedInUsers[$id])) {
                    http_response_code(401);
                    throw new AuthException();
                    return;
                }

                unset($loggedInUsers[$id]);
                file_put_contents(__DIR__ . '/example-repos/loggedInUsers/loggedInUsers.json', json_encode($loggedInUsers));
            } catch (\Firebase\JWT\ExpiredException $err) {
                http_response_code(403);
                echo json_encode(['error' => 'token expired']);
            } catch (UnexpectedValueException $err) {
                http_response_code(403);
                echo json_encode(['error' => 'invalid token']);
            } catch (Exception $exception) {
                http_response_code(401);
                throw new AuthException();
            }
        });
        $r->post('/api/get-new-access-token', function (Request $request) use ($secret) {

            self::initLoginFile();
            $content = file_get_contents(__DIR__ . '/example-repos/loggedInUsers/loggedInUsers.json');
            $loggedInUsers = json_decode($content, true);
            $key = findIndex($loggedInUsers, fn ($token) => $token === $request->body['refreshToken']);

            if ($key === -1) {
                http_response_code(404);
                return json_encode(['error' => 'not found']);
            }

            header('Content-type: application/json');
            $access =  new AccessToken(JWT::encode([
                "sub" => $key,
                "iat" => time(),
                "exp" => time() + 10,
            ], $secret));
            echo json_encode($access);
        });


        $r->get('/api/szallasok', function (Request $request) use ($secret) {
            header('Content-type: application/json');
            try {
                $headers = getallheaders();
                if (!preg_match('/Bearer\s(\S+)/', $headers['Authorization'] ?? '', $matches)) {
                    throw new AuthException('missing token');
                }
                $decoded = JWT::decode($matches[1], $secret, ['HS256']);
                echo file_get_contents(__DIR__ . '/example-repos/airbnb.json');
            } catch (\Firebase\JWT\ExpiredException $err) {
                http_response_code(403);
                echo json_encode(['error' => 'token expired']);
            } catch (UnexpectedValueException $err) {
                http_response_code(403);
                echo json_encode(['error' => 'invalid token']);
            } catch (Exception $exception) {
                http_response_code(401);
                throw new AuthException();
            }
        });
        $r->get('/api/szallasok/{id}', function (Request $request) use ($secret) {
            header('Content-type: application/json');
            try {
                $headers = getallheaders();
                if (!preg_match('/Bearer\s(\S+)/', $headers['Authorization'] ?? '', $matches)) {
                    throw new AuthException('missing token');
                }
                $decoded = JWT::decode($matches[1], $secret, ['HS256']);
                $content =  file_get_contents(__DIR__ . '/example-repos/airbnb.json');
                $items  = json_decode($content, true);

                $filtered = array_values(array_filter($items, fn ($item) => $item['id'] == $request->vars['id']));

                if (!count($filtered)) {
                    http_response_code(403);
                    echo json_encode(['error' => 'not found']);
                }

                echo json_encode($filtered[0]);
            } catch (\Firebase\JWT\ExpiredException $err) {
                http_response_code(403);
                echo json_encode(['error' => 'token expired']);
            } catch (UnexpectedValueException $err) {
                http_response_code(403);
                echo json_encode(['error' => 'invalid token']);
            } catch (Exception $exception) {
                http_response_code(401);
                throw new AuthException();
            }
        });
    }

    public static function registerInstrumentRoutes($r)
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
