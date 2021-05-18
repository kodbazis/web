<?php

namespace Kodbazis\Generated\Repository\Quote;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Quote\Update\UpdatedQuote;
use Kodbazis\Generated\Quote\Update\Updater;
use Kodbazis\Generated\Quote\Quote;
use mysqli;

class SqlUpdater implements Updater
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function update(string $id, UpdatedQuote $entity): Quote
    {
        try {
          $byId = (new SqlByIdGetter($this->connection))->byId($id);
          
          $stmt = $this->connection->prepare(
              'UPDATE `quotes` SET 
                `position` = ?, `courseId` = ?
                WHERE `id` = ?;'
          );
          
          $position= $entity->getPosition();
        $courseId= $entity->getCourseId();
         
          $stmt->bind_param(
              "iis",
               $position, $courseId, $id        
          );
          $stmt->execute();
          
          return new Quote($id, $byId->getContent(),$byId->getAuthor(),$entity->getPosition(),$entity->getCourseId(),$byId->getRating(),$byId->getCreatedAt());
      
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

