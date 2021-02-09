<?php

namespace Kodbazis\Generated\Repository\Quote;

use mysqli;
use Kodbazis\Generated\Quote\ById\ById;
use Kodbazis\Generated\Quote\Quote;
use Kodbazis\Generated\OperationError;

class SqlByIdGetter implements ById
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function byId(string $id): Quote
    {
        try {
            $stmt = $this->connection->prepare('SELECT * FROM `quotes` WHERE id = ?');
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return new Quote((int)$result['id'], (string)$result['content'], (string)$result['author'], (int)$result['position'], (int)$result['courseId'], (int)$result['createdAt']);
        
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

