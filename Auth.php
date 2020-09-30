<?php

namespace Kodbazis;

use FastRoute\RouteCollector;
use mysqli;
use Kodbazis\Generated\Auth\NewUser;
use Kodbazis\Generated\Repository\Auth\MySqlUserByEmailGetter;
use Kodbazis\Generated\Repository\Auth\MysqlUserSaver;
use Kodbazis\Generated\Request;
use Twig\Environment;

class Auth
{
    public static function getRoutes(Pipeline $r, mysqli $conn, Environment $twig)
    {
        $r->get('/login', function ($request) use ($conn, $twig) {
            header("Content-Type: text/html");
            $twig->display('login.twig');
        });

        $r->post('/logout', function ($request) use ($conn, $twig) {
            session_start();
            session_destroy();
            header("Location: /login");
        });

        $r->post('/login', function ($request) use ($conn, $twig) {
            $user = (new MySqlUserByEmailGetter($conn))->getUser($request->body['email'] ?? '');
            if (!password_verify($request->body['password'], $user->getPassword())) {
                header("Location: /");
                exit;
            }
            session_start();
            $_SESSION['id'] = $user->getId();
            header("Location: /admin");
        });
    }

    public static function validate(Request $request)
    {
        @session_start();
        if (empty($_SESSION['id'])) {
            header('Location: /');
            exit;
        }
        return $request;
    }
}
