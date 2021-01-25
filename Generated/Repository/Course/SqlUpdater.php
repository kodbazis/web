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
                `title` = ?, `content` = ?, `slug` = ?, `imgUrl` = ?, `videoId` = ?, `description` = ?, `isActive` = ?, `price` = ?, `discount` = ?
                WHERE `id` = ?;'
          );
          
          $title= $entity->getTitle();
        $content= $entity->getContent();
        $slug= $entity->getSlug();
        $imgUrl= $entity->getImgUrl();
        $videoId= $entity->getVideoId();
        $description= $entity->getDescription();
        $isActive= $entity->getIsActive();
        $price= $entity->getPrice();
        $discount= $entity->getDiscount();
         
          $stmt->bind_param(
              "ssssssiiis",
               $title, $content, $slug, $imgUrl, $videoId, $description, $isActive, $price, $discount, $id        
          );
          $stmt->execute();
          
          return new Course($id, $entity->getTitle(),$entity->getContent(),$entity->getSlug(),$entity->getImgUrl(),$entity->getVideoId(),$entity->getDescription(),$byId->getCreatedAt(),$entity->getIsActive(),$entity->getPrice(),$entity->getDiscount());
      
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

