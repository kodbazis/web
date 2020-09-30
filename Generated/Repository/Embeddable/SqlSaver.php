<?php

namespace Kodbazis\Generated\Repository\Embeddable;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Embeddable\Save\NewEmbeddable;
use Kodbazis\Generated\Embeddable\Save\Saver;
use Kodbazis\Generated\Embeddable\Embeddable;
use mysqli;

class SqlSaver implements Saver
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function Save(NewEmbeddable $new): Embeddable
    {
        try {
            $statement = $this->connection->prepare(
                "INSERT INTO `embeddables` (
                `id`, `createdAt`, `name`, `raw`, `type`
                ) 
                VALUES (NULL, ?,?,?,?);"
            );
    
            $createdAt = $new->getCreatedAt();
        $name = $new->getName();
        $raw = $new->getRaw();
        $type = $new->getType();
        
    
            $statement->bind_param(
                "isss",
                 $createdAt, $name, $raw, $type        
             );
            $statement->execute();
    
            return new Embeddable((string)$statement->insert_id, $new->getCreatedAt(),$new->getName(),$new->getRaw(),$new->getType());
        } catch (\Error $exception) {
            if ($_SERVER['DEPLOYMENT_ENV'] === 'dev') {
                var_dump($exception);
                exit;
            }
            throw new OperationError("save error");
        } catch (\Exception $exception) {
            if ($_SERVER['DEPLOYMENT_ENV'] === 'dev') {
                var_dump($exception);
                exit;
            }
            throw new OperationError("save error");
        }
    }
}

