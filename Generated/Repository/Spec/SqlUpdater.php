<?php

namespace Kodbazis\Generated\Repository\Spec;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Spec\Update\UpdatedSpec;
use Kodbazis\Generated\Spec\Update\Updater;
use Kodbazis\Generated\Spec\Spec;
use mysqli;

class SqlUpdater implements Updater
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function update(string $id, UpdatedSpec $entity): Spec
    {
        try {
          $byId = (new SqlByIdGetter($this->connection))->byId($id);
          
          $stmt = $this->connection->prepare(
              'UPDATE `specs` SET 
                `content` = ?, `position` = ?, `courseId` = ?
                WHERE `id` = ?;'
          );
          
          $content= $entity->getContent();
        $position= $entity->getPosition();
        $courseId= $entity->getCourseId();
         
          $stmt->bind_param(
              "siis",
               $content, $position, $courseId, $id        
          );
          $stmt->execute();
          
          return new Spec($id, $entity->getContent(),$entity->getPosition(),$entity->getCourseId(),$byId->getCreatedAt());
      
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

