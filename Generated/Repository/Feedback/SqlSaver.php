<?php

namespace Kodbazis\Generated\Repository\Feedback;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Feedback\Save\NewFeedback;
use Kodbazis\Generated\Feedback\Save\Saver;
use Kodbazis\Generated\Feedback\Feedback;
use mysqli;

class SqlSaver implements Saver
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function Save(NewFeedback $new): Feedback
    {
        try {
            $statement = $this->connection->prepare(
                "INSERT INTO `feedbacks` (
                `id`, `name`, `content`, `episodeId`, `createdAt`
                ) 
                VALUES (NULL, ?,?,?,?);"
            );
    
            $name = $new->getName();
        $content = $new->getContent();
        $episodeId = $new->getEpisodeId();
        $createdAt = $new->getCreatedAt();
        
    
            $statement->bind_param(
                "ssii",
                 $name, $content, $episodeId, $createdAt        
             );
            $statement->execute();
    
            return new Feedback((string)$statement->insert_id, $new->getName(),$new->getContent(),$new->getEpisodeId(),$new->getCreatedAt());
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

