<?php

namespace Kodbazis\Generated\Repository\Embeddable;

use mysqli;
use Kodbazis\Generated\Embeddable\ById\ById;
use Kodbazis\Generated\Embeddable\Embeddable;
use Kodbazis\Generated\OperationError;

class SqlByIdGetter implements ById
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function byId(string $id): Embeddable
    {
        try {
            $stmt = $this->connection->prepare('SELECT * FROM `embeddables` WHERE id = ?');
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return new Embeddable((int)$result['id'], (int)$result['createdAt'], (string)$result['name'], (string)$result['raw'], (string)$result['type']);
        
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

