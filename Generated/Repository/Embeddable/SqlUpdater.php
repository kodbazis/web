<?php

namespace Kodbazis\Generated\Repository\Embeddable;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Embeddable\Update\UpdatedEmbeddable;
use Kodbazis\Generated\Embeddable\Update\Updater;
use Kodbazis\Generated\Embeddable\Embeddable;
use mysqli;

class SqlUpdater implements Updater
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function update(string $id, UpdatedEmbeddable $entity): Embeddable
    {
        try {
          $byId = (new SqlByIdGetter($this->connection))->byId($id);
          
          $stmt = $this->connection->prepare(
              'UPDATE `embeddables` SET 
                `name` = ?, `raw` = ?, `type` = ?
                WHERE `id` = ?;'
          );
          
          $name= $entity->getName();
        $raw= $entity->getRaw();
        $type= $entity->getType();
         
          $stmt->bind_param(
              "ssss",
               $name, $raw, $type, $id        
          );
          $stmt->execute();
          
          return new Embeddable($id, $byId->getCreatedAt(),$entity->getName(),$entity->getRaw(),$entity->getType());
      
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

