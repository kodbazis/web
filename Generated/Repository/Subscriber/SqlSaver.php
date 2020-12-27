<?php

namespace Kodbazis\Generated\Repository\Subscriber;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Subscriber\Save\NewSubscriber;
use Kodbazis\Generated\Subscriber\Save\Saver;
use Kodbazis\Generated\Subscriber\Subscriber;
use mysqli;

class SqlSaver implements Saver
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function Save(NewSubscriber $new): Subscriber
    {
        try {
            $statement = $this->connection->prepare(
                "INSERT INTO `subscribers` (
                `id`, `email`, `password`, `isVerified`, `verificationToken`, `createdAt`
                ) 
                VALUES (NULL, ?,?,?,?,?);"
            );
    
            $email = $new->getEmail();
        $password = $new->getPassword();
        $isVerified = $new->getIsVerified();
        $verificationToken = $new->getVerificationToken();
        $createdAt = $new->getCreatedAt();
        
    
            $statement->bind_param(
                "ssisi",
                 $email, $password, $isVerified, $verificationToken, $createdAt        
             );
            $statement->execute();
    
            return new Subscriber((string)$statement->insert_id, $new->getEmail(),$new->getPassword(),$new->getIsVerified(),$new->getVerificationToken(),$new->getCreatedAt());
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

