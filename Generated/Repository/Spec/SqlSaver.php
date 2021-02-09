<?php

namespace Kodbazis\Generated\Repository\Spec;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Spec\Save\NewSpec;
use Kodbazis\Generated\Spec\Save\Saver;
use Kodbazis\Generated\Spec\Spec;
use mysqli;

class SqlSaver implements Saver
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function Save(NewSpec $new): Spec
    {
        try {
            $statement = $this->connection->prepare(
                "INSERT INTO `specs` (
                `id`, `content`, `position`, `courseId`, `createdAt`
                ) 
                VALUES (NULL, ?,?,?,?);"
            );
    
            $content = $new->getContent();
        $position = $new->getPosition();
        $courseId = $new->getCourseId();
        $createdAt = $new->getCreatedAt();
        
    
            $statement->bind_param(
                "siii",
                 $content, $position, $courseId, $createdAt        
             );
            $statement->execute();
    
            return new Spec((string)$statement->insert_id, $new->getContent(),$new->getPosition(),$new->getCourseId(),$new->getCreatedAt());
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

