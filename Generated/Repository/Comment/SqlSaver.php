<?php

namespace Kodbazis\Generated\Repository\Comment;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Comment\Save\NewComment;
use Kodbazis\Generated\Comment\Save\Saver;
use Kodbazis\Generated\Comment\Comment;
use mysqli;

class SqlSaver implements Saver
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function Save(NewComment $new): Comment
    {
        try {
            $statement = $this->connection->prepare(
                "INSERT INTO `comments` (
                `id`, `content`, `embeddableId`, `key`, `createdAt`
                ) 
                VALUES (NULL, ?,?,?,?);"
            );
    
            $content = $new->getContent();
        $embeddableId = $new->getEmbeddableId();
        $key = $new->getKey();
        $createdAt = $new->getCreatedAt();
        
    
            $statement->bind_param(
                "sisi",
                 $content, $embeddableId, $key, $createdAt        
             );
            $statement->execute();
    
            return new Comment((string)$statement->insert_id, $new->getContent(),$new->getEmbeddableId(),$new->getKey(),$new->getCreatedAt());
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

