<?php

namespace Kodbazis\Generated\Repository\Post;

use mysqli;
use Kodbazis\Generated\Post\ById\ById;
use Kodbazis\Generated\Post\Post;
use Kodbazis\Generated\OperationError;

class SqlByIdGetter implements ById
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function byId(string $id): Post
    {
        try {
            $stmt = $this->connection->prepare('SELECT * FROM `posts` WHERE id = ?');
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return new Post((int)$result['id'], (string)$result['title'], (string)$result['slug'], (string)$result['imgUrl'], (int)$result['createdAt'], (int)$result['publishedAt'], (string)$result['description'], (string)$result['content'], (string)$result['imgAltTag'], (bool)$result['isActive']);
        
        } catch (\Error $exception) {
            if ($_SERVER['DEPLOYMENT_ENV'] === 'dev') {
                var_dump($exception);
                exit;
            }
            throw new OperationError("by id error");
        } catch (\Exception $exception) {
            if ($_SERVER['DEPLOYMENT_ENV'] === 'dev') {
                var_dump($exception);
                exit;
            }
            throw new OperationError("by id error");
        }
    }
}

