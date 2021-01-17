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
                `title` = ?, `slug` = ?, `imgUrl` = ?, `description` = ?, `isActive` = ?, `price` = ?
                WHERE `id` = ?;'
          );
          
          $title= $entity->getTitle();
        $slug= $entity->getSlug();
        $imgUrl= $entity->getImgUrl();
        $description= $entity->getDescription();
        $isActive= $entity->getIsActive();
        $price= $entity->getPrice();
         
          $stmt->bind_param(
              "ssssiis",
               $title, $slug, $imgUrl, $description, $isActive, $price, $id        
          );
          $stmt->execute();
          
          return new Course($id, $entity->getTitle(),$entity->getSlug(),$entity->getImgUrl(),$entity->getDescription(),$byId->getCreatedAt(),$entity->getIsActive(),$entity->getPrice());
      
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

