<?php

namespace Kodbazis\Generated\Route\Auth;

use Exception;
use FastRoute\RouteCollector;
use mysqli;
use Kodbazis\Generated\Request;
use Kodbazis\Generated\Auth\AuthException;
use Kodbazis\Generated\Auth\LoginController;
use Kodbazis\Generated\Auth\LogoutController;
use Kodbazis\Generated\Auth\RefreshController;
use Kodbazis\Generated\Auth\RegistrationController;
use Kodbazis\Generated\Auth\UserListController;
use Kodbazis\Generated\Repository\Auth\JwtTokenGetter;
use Kodbazis\Generated\Repository\Auth\JwtTokenVerifier;
use Kodbazis\Generated\Repository\Auth\MysqlRawTokenGetter;
use Kodbazis\Generated\Repository\Auth\MysqlRefreshTokenSaver;
use Kodbazis\Generated\Repository\Auth\MysqlTokenDeleter;
use Kodbazis\Generated\Repository\Auth\MySqlUserByEmailGetter;
use Kodbazis\Generated\Repository\Auth\MysqlUserLister;
use Kodbazis\Generated\Repository\Auth\MysqlUserSaver;

class Auth
{
    public static function getRoutes(RouteCollector $r, mysqli $conn)
    {
        $r->post('/api/register', self::register($conn));
        $r->post('/api/login', self::login($conn));
        $r->get('/api/users', self::listUsers($conn));
        $r->post('/api/refresh', self::refresh($conn));
        $r->post('/api/logout', self::logout($conn));
    }

    private static function login(mysqli $conn)
    {
        return function (Request $request) use ($conn) {
            $res = (new LoginController(
                new JwtTokenGetter(),
                new MySqlUserByEmailGetter($conn),
                new MysqlRefreshTokenSaver($conn)
            ))->authenticate($request->body);

            return json_encode($res);
        };
    }

    private static function register(mysqli $conn)
    {
        return function (Request $request) use ($conn) {
            if(!$request->body['pw'] !== $_SERVER['MASTER_PW']) {
                return;
            }
            $res = (new RegistrationController(
                new MysqlUserSaver($conn),
                new MySqlUserByEmailGetter($conn),
                new JwtTokenGetter(),
                new MysqlRefreshTokenSaver($conn)
            ))->register($request->body);

            return json_encode($res);

        };
    }

    private static function listUsers(mysqli $conn)
    {
        return function (Request $request) use ($conn) {
            try {
                $headers = getallheaders();

                if (!preg_match('/Bearer\s(\S+)/', $headers['Authorization'] ?? '', $matches)) {
                    throw new AuthException('missing token');
                }

                $ctrl = new UserListController(new MysqlUserLister($conn), new JwtTokenVerifier());
                $res = $ctrl->listUsers($matches[1]);
                return json_encode($res);
            } catch (Exception $err) {
                return json_encode($err);
            }
        };
    }

    private static function refresh(mysqli $conn)
    {
        return function (Request $request) use ($conn) {
            return json_encode((new RefreshController(
                new JwtTokenVerifier(),
                new MysqlRawTokenGetter($conn),
                new JwtTokenGetter()
            ))->refresh($request->body['refreshToken'] ?? ''));
        };
    }

    private static function logout(mysqli $conn)
    {
        return function (Request $request) use ($conn) {
            return json_encode((new LogoutController(
                new MysqlTokenDeleter($conn)
            ))->logout($request->body['refreshToken'] ?? ''));
        };
    }
}
