<?php

namespace Kodbazis\Generated\Repository\Comment;

use mysqli;
use Kodbazis\Generated\Comment\ById\ById;
use Kodbazis\Generated\Comment\Comment;
use Kodbazis\Generated\OperationError;

class SqlByIdGetter implements ById
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function byId(string $id): Comment
    {
        try {
            $stmt = $this->connection->prepare('SELECT * FROM `comments` WHERE id = ?');
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return new Comment((int)$result['id'], (string)$result['content'], (int)$result['embeddableId'], (string)$result['key'], (int)$result['createdAt']);
        
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

