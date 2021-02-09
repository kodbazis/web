<?php

namespace Kodbazis\Generated\Repository\Quote;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Quote\Save\NewQuote;
use Kodbazis\Generated\Quote\Save\Saver;
use Kodbazis\Generated\Quote\Quote;
use mysqli;

class SqlSaver implements Saver
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function Save(NewQuote $new): Quote
    {
        try {
            $statement = $this->connection->prepare(
                "INSERT INTO `quotes` (
                `id`, `content`, `author`, `position`, `courseId`, `createdAt`
                ) 
                VALUES (NULL, ?,?,?,?,?);"
            );
    
            $content = $new->getContent();
        $author = $new->getAuthor();
        $position = $new->getPosition();
        $courseId = $new->getCourseId();
        $createdAt = $new->getCreatedAt();
        
    
            $statement->bind_param(
                "ssiii",
                 $content, $author, $position, $courseId, $createdAt        
             );
            $statement->execute();
    
            return new Quote((string)$statement->insert_id, $new->getContent(),$new->getAuthor(),$new->getPosition(),$new->getCourseId(),$new->getCreatedAt());
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

