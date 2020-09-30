<?php

namespace Kodbazis\Generated\Repository\Auth;

use Kodbazis\Generated\Auth\PublicUser;
use Kodbazis\Generated\Auth\UserLister;

class MysqlUserLister implements UserLister
{
    private $connection;

    public function __construct(\mysqli $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return PublicUser[]
     */
    public function listUsers(): array
    {
        $stmt = $this->connection->prepare('SELECT * FROM `users`');
        $stmt->execute();
        $result = $stmt->get_result();

        $results = [];
        while ($data = $result->fetch_assoc()) {
            $results[] = $data;
        }

        return array_map(function ($user) {
            return new PublicUser($user['id'], $user['email']);
        }, $results);
    }
}
