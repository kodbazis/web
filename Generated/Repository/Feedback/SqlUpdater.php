<?php

namespace Kodbazis\Generated\Repository\Feedback;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Feedback\Update\UpdatedFeedback;
use Kodbazis\Generated\Feedback\Update\Updater;
use Kodbazis\Generated\Feedback\Feedback;
use mysqli;

class SqlUpdater implements Updater
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function update(string $id, UpdatedFeedback $entity): Feedback
    {
        try {
          $byId = (new SqlByIdGetter($this->connection))->byId($id);
          
          $stmt = $this->connection->prepare(
              'UPDATE `feedbacks` SET 
                `episodeId` = ?
                WHERE `id` = ?;'
          );
          
          $episodeId= $entity->getEpisodeId();
         
          $stmt->bind_param(
              "is",
               $episodeId, $id        
          );
          $stmt->execute();
          
          return new Feedback($id, $byId->getName(),$byId->getContent(),$entity->getEpisodeId(),$byId->getCreatedAt());
      
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

