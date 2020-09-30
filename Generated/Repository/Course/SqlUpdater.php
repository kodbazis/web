<?php

namespace Kodbazis\Generated\Repository\Course;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Course\Update\UpdatedCourse;
use Kodbazis\Generated\Course\Update\Updater;
use Kodbazis\Generated\Course\Course;
use mysqli;

class SqlUpdater implements Updater
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function update(string $id, UpdatedCourse $entity): Course
    {
        try {
          $byId = (new SqlByIdGetter($this->connection))->byId($id);
          
          $stmt = $this->connection->prepare(
              'UPDATE `courses` SET 
                `title` = ?, `slug` = ?, `imgUrl` = ?, `description` = ?, `videoUrl` = ?, `isActive` = ?
                WHERE `id` = ?;'
          );
          
          $title= $entity->getTitle();
        $slug= $entity->getSlug();
        $imgUrl= $entity->getImgUrl();
        $description= $entity->getDescription();
        $videoUrl= $entity->getVideoUrl();
        $isActive= $entity->getIsActive();
         
          $stmt->bind_param(
              "sssssis",
               $title, $slug, $imgUrl, $description, $videoUrl, $isActive, $id        
          );
          $stmt->execute();
          
          return new Course($id, $entity->getTitle(),$entity->getSlug(),$entity->getImgUrl(),$entity->getDescription(),$entity->getVideoUrl(),$byId->getCreatedAt(),$entity->getIsActive());
      
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

