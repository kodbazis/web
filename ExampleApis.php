<?php

namespace Kodbazis;

use Kodbazis\Generated\Request;
use mysqli;
use Twig\Environment;
use Firebase\JWT\JWT;
use Kodbazis\Generated\Auth\AccessToken;
use Kodbazis\Generated\Auth\AuthException;
use Kodbazis\Generated\Auth\RefreshToken;
use UnexpectedValueException;

class ExampleApis
{

    public static function getRoutes(Pipeline $r, mysqli $conn, Environment $twig)
    {
        self::registerInstrumentRoutes($r);
        self::registerRecipeRoutes($r);
        self::registerAuthRoutes($r);
    }

    public static function registerAuthRoutes($r)
    {

        $r->get("/api/exchangerates", function (Request $request) {
            header('Content-type: application/json');
            if (!isset($request->query["base"])) {
                echo json_encode(["error" => "base query parameter missing"]);
                return;
            }

            if (!in_array(strtoupper($request->query["base"]), ["HUF", "EUR", "USD", "RUB"])) {
                echo json_encode(["error" => "invalid currency"]);
                return;
            }

            $contents = file_get_contents(__DIR__ . "/example-repos/rates.json");
            $rates = json_decode($contents, true);
            echo json_encode(["rates" => $rates[strtoupper($request->query["base"])], "base" => strtoupper($request->query["base"])]);
        });

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
                "exp" => time() + 15,
            ], $secret));

            $refresh = new RefreshToken(JWT::encode([
                "iat" => time(),
                'expires' => time() + 60 * 60 * 24 * 29,
            ], $secret));

            setcookie('kodbazisRefreshToken', $refresh->getValue(), [
                'expires' => time() + 60 * 60 * 24 * 30,
                'httponly' => true,
                'secure' => true,
                'samesite' => 'None',
            ]);

            echo json_encode($access);
        });

        $r->get('/api/get-new-access-token', function (Request $request) use ($secret) {
            try {
                $decoded = JWT::decode($_COOKIE['kodbazisRefreshToken'] ?? '', $secret, ['HS256']);
                $access =  new AccessToken(JWT::encode([
                    "sub" => '',
                    "iat" => time(),
                    "exp" => time() + 15,
                ], $secret));
                header('Content-type: application/json');
                echo json_encode($access);
            } catch (\Firebase\JWT\ExpiredException $err) {
                http_response_code(403);
                header('Content-type: application/json');
                echo json_encode(['error' => 'token expired']);
            } catch (UnexpectedValueException $err) {
                http_response_code(403);
                header('Content-type: application/json');
                echo json_encode(['error' => 'unauthorized']);
            } catch (Exception $exception) {
                http_response_code(401);
                throw new AuthException();
            }
        });


        $r->post('/api/logout-user', function () use ($secret) {
            header('Content-type: application/json');
            try {
                setcookie('kodbazisRefreshToken', false, [
                    'expires' => 1,
                    'httponly' => true,
                    'secure' => true,
                    'samesite' => 'None',
                ]);
            } catch (\Firebase\JWT\ExpiredException $err) {
                http_response_code(403);
                echo json_encode(['error' => 'token expired']);
            } catch (UnexpectedValueException $err) {
                http_response_code(403);
                echo json_encode(['error' => 'unauthorized']);
            } catch (Exception $exception) {
                http_response_code(401);
                throw new AuthException();
            }
        });

        $r->get('/api/szallasok', function (Request $request) use ($secret) {
            header('Content-type: application/json');
            try {
                $headers = getallheaders();
                if (!preg_match('/Bearer\s(\S+)/', $headers['Authorization'] ?? '', $matches)) {
                    http_response_code(403);
                    echo json_encode(['error' => 'unauthorized']);
                    return;
                }
                $decoded = JWT::decode($matches[1], $secret, ['HS256']);
                echo file_get_contents(__DIR__ . '/example-repos/airbnb.json');
            } catch (\Firebase\JWT\ExpiredException $err) {
                http_response_code(403);
                echo json_encode(['error' => 'token expired']);
            } catch (UnexpectedValueException $err) {
                http_response_code(403);
                echo json_encode(['error' => 'unauthorized']);
            } catch (\Exception $exception) {
                http_response_code(403);
                echo json_encode(['error' => 'unauthorized']);
            }
        });
        $r->get('/api/szallasok/{id}', function (Request $request) use ($secret) {
            header('Content-type: application/json');
            try {
                $headers = getallheaders();
                if (!preg_match('/Bearer\s(\S+)/', $headers['Authorization'] ?? '', $matches)) {
                    http_response_code(403);
                    echo json_encode(['error' => 'unauthorized']);
                    return;
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
                echo json_encode(['error' => 'unauthorized']);
            } catch (\Exception $exception) {
                http_response_code(403);
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

    public static function registerRecipeRoutes($r)
    {
        header("Access-Control-Allow-Origin:" . ($_SERVER['HTTP_ORIGIN'] ?? '*'));
        header("Access-Control-Allow-Credentials: true");
        $folder = __DIR__ . "/example-repos/recipes";
        $imagefileName = __DIR__ . '/example-repos/recipes.json';

        $getFileName = function ($folder) use ($imagefileName) {
            if (isset($_COOKIE['recipesAPIID']) && @file_get_contents($folder . '/' . $_COOKIE['recipesAPIID'] . '.json')) {
                return $_COOKIE['recipesAPIID'] . '.json';
            }

            $id = uniqid();

            setcookie('recipesAPIID', $id, [
                'expires' => time() + 60 * 60 * 24,
            ]);
            $fileName = $id . '.json';
            copy($imagefileName,  $folder . '/' .  $fileName);
            return $fileName;
        };

        $getContent = function ($folder) use ($imagefileName) {
            $content = '';
            if (isset($_COOKIE['recipesAPIID']) && @file_get_contents($folder . '/' . $_COOKIE['recipesAPIID'] . '.json')) {
                $fileName = $_COOKIE['recipesAPIID'] . '.json';
                $content = file_get_contents($folder . '/' .  $fileName);
            } else {
                $content = file_get_contents($imagefileName);
            }
            return $content;
        };

        $r->get('/recipe-app/api/recipes', function (Request $request) use ($folder, $getContent) {
            header('Content-Type: application/json');
            echo $getContent($folder);
        });

        $r->get('/recipe-app/static/images/{filename}', function (Request $request) {
            $fileName = __DIR__ . '/example-repos/recipe-images/' . $request->vars['filename'];
            $size = filesize($fileName);
            header('Content-Type: image/jpeg');
            header("Content-Length: $size bytes");
            readfile($fileName);
        });
        $r->get('/recipe-app/static/assets/{filename}', function (Request $request) {
            $fileName = __DIR__ . '/example-repos/recipe-images/' . $request->vars['filename'];
            $size = filesize($fileName);
            header('Content-Type: image/jpeg');
            header("Content-Length: $size bytes");
            readfile($fileName);
        });

        $r->post('/api/prune-recipes', function (Request $request) use ($folder) {
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

        $r->get('/recipe-app/api/recipes/{slug}', function (Request $request) use ($folder, $getContent) {
            header('Content-Type: application/json');

            $recipes = json_decode($getContent($folder), true);
            $byId = array_values(array_filter($recipes, fn ($recipe) => $recipe['slug'] === $request->vars['slug']));
            if (isset($byId[0])) {
                return json_encode($byId[0]);
            } else {
                http_response_code(404);
                return json_encode(['error' => 'not found']);
            }
        });

        $r->post('/recipe-app/api/recipes', function (Request $request) use ($folder, $getFileName) {
            header('Content-Type: application/json');

            createPath($folder);
            $fileName = $getFileName($folder);

            $content = file_get_contents($folder . '/' .  $fileName);
            $recipes = json_decode($content, true);
            if (count($recipes) > 100) {
                http_response_code(400);
                echo ['error' => 'max size exceeded'];
                return;
            }

            $newItem = [
                "id" => uniqid(),
                "name" => $request->body['name'],
                "slug" => (new \Kodbazis\Generated\Slugifier\Slugifier())->slugify($request->body['name']),
                "ingredients" => json_decode($request->body['ingredients']),
                "steps" => json_decode($request->body['steps']),
                "imageURL" => "placeholder.webp"
            ];
            $recipes[] = $newItem;
            file_put_contents($folder . '/' .  $fileName, json_encode($recipes, JSON_UNESCAPED_UNICODE));
            echo json_encode($newItem);
        });

        $r->put('/recipe-app/api/recipes/{id}', function (Request $request) use ($folder, $getFileName) {
            header('Content-Type: application/json');

            createPath($folder);
            $fileName = $getFileName($folder);

            $content = file_get_contents($folder . '/' .  $fileName);
            $recipes = json_decode($content, true);

            $index = findIndex($recipes, fn ($instrument) => $instrument['id'] === $request->vars['id']);

            if ($index === -1) {
                http_response_code(404);
                return json_encode(['error' => 'not found']);
            }
            $data  = file_get_contents('php://input');
            $headers = [];
            $request->body = parseFormData($data, $headers);

            $newItem = [
                'id' => $recipes[$index]['id'],
                'name' => filter_var((string)$request->body['name'], FILTER_SANITIZE_STRING),
                "slug" => $recipes[$index]['slug'],
                "ingredients" => json_decode($request->body['ingredients']),
                "steps" => json_decode($request->body['steps']),
                "imageURL" => $recipes[$index]['imageURL'],
            ];

            $recipes[$index] = $newItem;
            file_put_contents($folder . '/' .  $fileName, json_encode($recipes));
            echo json_encode($newItem);
        });

        $r->delete('/recipe-app/api/recipes/{id}', function (Request $request) use ($folder, $getFileName) {
            header('Content-Type: application/json');

            createPath($folder);
            $fileName = $getFileName($folder);

            $content = file_get_contents($folder . '/' .  $fileName);
            $recipes = json_decode($content, true);

            $index = findIndex($recipes, fn ($recipe) => $recipe['id'] === $request->vars['id']);

            if ($index === -1) {
                http_response_code(404);
                return json_encode(['error' => 'not found']);
            }

            array_splice($recipes, $index, 1);
            file_put_contents($folder . '/' .  $fileName, json_encode($recipes));
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

function parseFormData($formData, &$header)
{
    $endOfFirstLine = strpos($formData, "\r\n");
    $boundary = substr($formData, 0, $endOfFirstLine);
    // Split form-data into each entry
    $parts = explode($boundary, $formData);
    $return = [];
    $header = [];
    // Remove first and last (null) entries
    array_shift($parts);
    array_pop($parts);
    foreach ($parts as $part) {
        $endOfHead = strpos($part, "\r\n\r\n");
        $startOfBody = $endOfHead + 4;
        $head = substr($part, 2, $endOfHead - 2);
        $body = substr($part, $startOfBody, -2);
        $headerParts = preg_split('#; |\r\n#', $head);
        $key = null;
        $thisHeader = [];
        // Parse the mini headers,
        // obtain the key
        foreach ($headerParts as $headerPart) {
            if (preg_match('#(.*)(=|: )(.*)#', $headerPart, $keyVal)) {
                if ($keyVal[1] == "name") $key = substr($keyVal[3], 1, -1);
                else {
                    if ($keyVal[2] == "=") {
                        $thisHeader[$keyVal[1]] = substr($keyVal[3], 1, -1);
                    } else {
                        $thisHeader[$keyVal[1]] = $keyVal[3];
                    }
                }
            }
        }
        // If the key is multidimensional,
        // generate multidimentional array
        // based off of the parts
        $nameParts = preg_split('#(?=\[.*\])#', $key);
        if (count($nameParts) > 1) {
            $current = &$return;
            $currentHeader = &$header;
            $l = count($nameParts);
            for ($i = 0; $i < $l; $i++) {
                // Strip array access tokens
                $namePart = preg_replace('#[\[\]]#', "", $nameParts[$i]);

                // If we are at the end of the depth of this entry,
                // add data to array
                if ($i == $l - 1) {
                    if (isset($thisHeader['filename'])) {
                        $filename = tempnam(sys_get_temp_dir(), "php");
                        file_put_contents($filename, $body);
                        $current[$namePart] = [
                            "name" => $thisHeader['filename'],
                            "type" => $thisHeader['Content-Type'],
                            "tmp_name" => $filename,
                            "error" => 0,
                            "size" => count($body)
                        ];
                    } else {
                        $current[$namePart] = $body;
                    }
                    $currentHeader[$namePart] = $thisHeader;
                } else {
                    // Advance into the array
                    if (!isset($current[$namePart])) {
                        $current[$namePart] = [];
                        $currentHeader[$namePart] = [];
                    }
                    $current = &$current[$namePart];
                    $currentHeader = &$currentHeader[$namePart];
                }
            }
        } else {
            if (isset($thisHeader['filename'])) {
                $filename = tempnam(sys_get_temp_dir(), "php");
                file_put_contents($filename, $body);
                $return[$key] = [
                    "name" => $thisHeader['filename'],
                    "type" => $thisHeader['Content-Type'],
                    "tmp_name" => $filename,
                    "error" => 0,
                    "size" => count($body)
                ];
            } else {
                $return[$key] = $body;
            }
            $return[$key] = $body;
            $header[$key] = $thisHeader;
        }
    }
    return $return;
}
