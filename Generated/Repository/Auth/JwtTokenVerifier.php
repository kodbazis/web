<?php

namespace Kodbazis\Generated\Repository\Auth;

use Exception;
use Firebase\JWT\ExpiredException as JWTExpiredException;
use Firebase\JWT\JWT;
use Kodbazis\Generated\Auth\AuthException;
use Kodbazis\Generated\Auth\Claims;
use Kodbazis\Generated\Auth\ExpiredException;
use Kodbazis\Generated\Auth\TokenVerifier;

class JwtTokenVerifier implements TokenVerifier
{
    public function verify(string $token): ?Claims
    {
        try {
            $decoded = JWT::decode($token, $_SERVER['ACCESS_TOKEN_SECRET'], ['HS256']);
            return new Claims($decoded->sub);
        } catch (JWTExpiredException $err) {
            throw new ExpiredException();
        } catch (Exception $exception) {
            throw new AuthException();
        }
    }
}
