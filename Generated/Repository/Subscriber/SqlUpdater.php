<?php

namespace Kodbazis\Generated\Repository\Subscriber;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Subscriber\Update\UpdatedSubscriber;
use Kodbazis\Generated\Subscriber\Update\Updater;
use Kodbazis\Generated\Subscriber\Subscriber;
use mysqli;

class SqlUpdater implements Updater
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function update(string $id, UpdatedSubscriber $entity): Subscriber
    {
        try {
          $byId = (new SqlByIdGetter($this->connection))->byId($id);
          
          $stmt = $this->connection->prepare(
              'UPDATE `subscribers` SET 
                `email` = ?, `password` = ?, `isVerified` = ?, `verificationToken` = ?
                WHERE `id` = ?;'
          );
          
          $email= $entity->getEmail();
        $password= $entity->getPassword();
        $isVerified= $entity->getIsVerified();
        $verificationToken= $entity->getVerificationToken();
         
          $stmt->bind_param(
              "ssiss",
               $email, $password, $isVerified, $verificationToken, $id        
          );
          $stmt->execute();
          
          return new Subscriber($id, $entity->getEmail(),$entity->getPassword(),$entity->getIsVerified(),$entity->getVerificationToken(),$byId->getCreatedAt());
      
      } catch (\Error $exception) {
          if ($_SERVER['DEPLOYMENT_ENV'] === 'dev') {
            var_dump($exception);
            exit;
          }
          throw new OperationError("update error");
      } catch (\Exception $exception) {
          if ($_SERVER['DEPLOYMENT_ENV'] === 'dev') {
            var_dump($exception);
            exit;
          }
          throw new OperationError("update error");
      }
    }
}

