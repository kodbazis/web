<?php

namespace Kodbazis\Generated\Repository\Message;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Message\Save\NewMessage;
use Kodbazis\Generated\Message\Save\Saver;
use Kodbazis\Generated\Message\Message;
use mysqli;

class SqlSaver implements Saver
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function Save(NewMessage $new): Message
    {
        try {
            $statement = $this->connection->prepare(
                "INSERT INTO `messages` (
                `id`, `email`, `subject`, `body`, `status`, `numberOfAttempts`, `sentAt`, `createdAt`
                ) 
                VALUES (NULL, ?,?,?,?,?,?,?);"
            );
    
            $email = $new->getEmail();
        $subject = $new->getSubject();
        $body = $new->getBody();
        $status = $new->getStatus();
        $numberOfAttempts = $new->getNumberOfAttempts();
        $sentAt = $new->getSentAt();
        $createdAt = $new->getCreatedAt();
        
    
            $statement->bind_param(
                "ssssiii",
                 $email, $subject, $body, $status, $numberOfAttempts, $sentAt, $createdAt        
             );
            $statement->execute();
    
            return new Message((string)$statement->insert_id, $new->getEmail(),$new->getSubject(),$new->getBody(),$new->getStatus(),$new->getNumberOfAttempts(),$new->getSentAt(),$new->getCreatedAt());
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

