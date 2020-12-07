<?php

namespace Kodbazis\Generated\Repository\Course;

use mysqli;
use Kodbazis\Generated\Course\ById\ById;
use Kodbazis\Generated\Course\Course;
use Kodbazis\Generated\OperationError;

class SqlByIdGetter implements ById
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function byId(string $id): Course
    {
        try {
            $stmt = $this->connection->prepare('SELECT * FROM `courses` WHERE id = ?');
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return new Course((int)$result['id'], (string)$result['title'], (string)$result['slug'], (string)$result['imgUrl'], (string)$result['description'], (int)$result['createdAt'], (bool)$result['isActive']);
        
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

