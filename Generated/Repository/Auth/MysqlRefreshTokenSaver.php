<?php

namespace Kodbazis\Generated\Repository\Auth;

use Kodbazis\Generated\Auth\RawToken;
use Kodbazis\Generated\Auth\RefreshToken;
use Kodbazis\Generated\Auth\RefreshTokenSaver;

class MysqlRefreshTokenSaver implements RefreshTokenSaver
{
    private $connection;

    public function __construct(\mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function save(RawToken $token): RefreshToken
    {
        $stmt = $this->connection->prepare('INSERT INTO `tokens` (`id`, `userId`, `value`) VALUES (NULL, ?, ?)');

        call_user_func(function ($userId, $token) use ($stmt) {
            $stmt->bind_param('ss', $userId, $token);
        }, $token->getUserId(), $token->getRefreshToken()->getValue());

        $stmt->execute();

        return $token->getRefreshToken();
    }
}
