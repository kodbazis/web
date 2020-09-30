<?php

namespace Kodbazis\Generated\Repository\Auth;

use Firebase\JWT\JWT;
use Kodbazis\Generated\Auth\AccessToken;
use Kodbazis\Generated\Auth\RefreshToken;
use Kodbazis\Generated\Auth\TokenGetter;

class JwtTokenGetter implements TokenGetter
{
    public function getAccessToken(string $userId): AccessToken
    {
        return new AccessToken(JWT::encode([
            "sub" => $userId,
            "iat" => time(),
            "exp" => time() + 60 * 10,
        ], $_SERVER['ACCESS_TOKEN_SECRET']));
    }

    public function getRefreshToken(): RefreshToken
    {
        return new RefreshToken(JWT::encode([
            "iat" => time(),
            "exp" => time() + 60 * 60 * 24 * 30,
        ], $_SERVER['REFRESH_TOKEN_SECRET']));
    }
}