<?php

namespace Kodbazis\Generated\Repository\Episode;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Episode\Update\UpdatedEpisode;
use Kodbazis\Generated\Episode\Update\Updater;
use Kodbazis\Generated\Episode\Episode;
use mysqli;

class SqlUpdater implements Updater
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function update(string $id, UpdatedEpisode $entity): Episode
    {
        try {
          $byId = (new SqlByIdGetter($this->connection))->byId($id);
          
          $stmt = $this->connection->prepare(
              'UPDATE `episodes` SET 
                `title` = ?, `slug` = ?, `courseId` = ?, `imgUrl` = ?, `description` = ?, `shortDescription` = ?, `content` = ?, `position` = ?, `isActive` = ?, `isPreview` = ?
                WHERE `id` = ?;'
          );
          
          $title= $entity->getTitle();
        $slug= $entity->getSlug();
        $courseId= $entity->getCourseId();
        $imgUrl= $entity->getImgUrl();
        $description= $entity->getDescription();
        $shortDescription= $entity->getShortDescription();
        $content= $entity->getContent();
        $position= $entity->getPosition();
        $isActive= $entity->getIsActive();
        $isPreview= $entity->getIsPreview();
         
          $stmt->bind_param(
              "ssissssiiis",
               $title, $slug, $courseId, $imgUrl, $description, $shortDescription, $content, $position, $isActive, $isPreview, $id        
          );
          $stmt->execute();
          
          return new Episode($id, $entity->getTitle(),$entity->getSlug(),$entity->getCourseId(),$entity->getImgUrl(),$entity->getDescription(),$entity->getShortDescription(),$entity->getContent(),$byId->getCreatedAt(),$entity->getPosition(),$entity->getIsActive(),$entity->getIsPreview());
      
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

