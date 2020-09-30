<?php

namespace Kodbazis\Generated\Repository\Auth;

use Kodbazis\Generated\Auth\RawToken;
use Kodbazis\Generated\Auth\RawTokenGetter;
use Kodbazis\Generated\Auth\RefreshToken;

class MysqlRawTokenGetter implements RawTokenGetter
{
    private $connection;

    public function __construct(\mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function getRawToken(string $refreshTokenValue): ?RawToken
    {
        $stmt = $this->connection->prepare('SELECT * FROM `tokens` WHERE value = ?');
        $stmt->bind_param('s', $refreshTokenValue);

        $stmt->execute();
        $result = $stmt->get_result();

        $results = [];
        while ($data = $result->fetch_assoc()) {
            $results[] = $data;
        }

        if (count($results) === 0) {
            return null;
        }

        return new RawToken($results[0]['userId'], new RefreshToken($results[0]['value']));
    }


}