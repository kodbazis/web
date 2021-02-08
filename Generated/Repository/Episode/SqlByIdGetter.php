<?php

namespace Kodbazis\Generated\Repository\Episode;

use mysqli;
use Kodbazis\Generated\Episode\ById\ById;
use Kodbazis\Generated\Episode\Episode;
use Kodbazis\Generated\OperationError;

class SqlByIdGetter implements ById
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function byId(string $id): Episode
    {
        try {
            $stmt = $this->connection->prepare('SELECT * FROM `episodes` WHERE id = ?');
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return new Episode((int)$result['id'], (string)$result['title'], (string)$result['slug'], (int)$result['courseId'], (string)$result['imgUrl'], (string)$result['description'], (string)$result['shortDescription'], (string)$result['content'], (int)$result['createdAt'], (int)$result['position'], (bool)$result['isActive'], (bool)$result['isPreview']);
        
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

