<?php

namespace Kodbazis\Generated\Repository\Comment;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Comment\Update\UpdatedComment;
use Kodbazis\Generated\Comment\Update\Updater;
use Kodbazis\Generated\Comment\Comment;
use mysqli;

class SqlUpdater implements Updater
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function update(string $id, UpdatedComment $entity): Comment
    {
        try {
          $byId = (new SqlByIdGetter($this->connection))->byId($id);
          
          $stmt = $this->connection->prepare(
              'UPDATE `comments` SET 
                
                WHERE `id` = ?;'
          );
          
           
          $stmt->bind_param(
              "s",
               , $id        
          );
          $stmt->execute();
          
          return new Comment($id, $byId->getContent(),$byId->getEmbeddableId(),$byId->getKey(),$byId->getCreatedAt());
      
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

