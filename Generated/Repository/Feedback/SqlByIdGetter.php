<?php

namespace Kodbazis\Generated\Repository\Feedback;

use mysqli;
use Kodbazis\Generated\Feedback\ById\ById;
use Kodbazis\Generated\Feedback\Feedback;
use Kodbazis\Generated\OperationError;

class SqlByIdGetter implements ById
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function byId(string $id): Feedback
    {
        try {
            $stmt = $this->connection->prepare('SELECT * FROM `feedbacks` WHERE id = ?');
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return new Feedback((int)$result['id'], (string)$result['name'], (string)$result['content'], (int)$result['episodeId'], (int)$result['createdAt']);
        
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

