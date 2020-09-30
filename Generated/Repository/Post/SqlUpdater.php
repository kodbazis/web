<?php

namespace Kodbazis\Generated\Repository\Post;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Post\Update\UpdatedPost;
use Kodbazis\Generated\Post\Update\Updater;
use Kodbazis\Generated\Post\Post;
use mysqli;

class SqlUpdater implements Updater
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function update(string $id, UpdatedPost $entity): Post
    {
        try {
          $byId = (new SqlByIdGetter($this->connection))->byId($id);
          
          $stmt = $this->connection->prepare(
              'UPDATE `posts` SET 
                `title` = ?, `slug` = ?, `imgUrl` = ?, `publishedAt` = ?, `description` = ?, `content` = ?, `imgAltTag` = ?, `isActive` = ?
                WHERE `id` = ?;'
          );
          
          $title= $entity->getTitle();
        $slug= $entity->getSlug();
        $imgUrl= $entity->getImgUrl();
        $publishedAt= $entity->getPublishedAt();
        $description= $entity->getDescription();
        $content= $entity->getContent();
        $imgAltTag= $entity->getImgAltTag();
        $isActive= $entity->getIsActive();
         
          $stmt->bind_param(
              "sssisssis",
               $title, $slug, $imgUrl, $publishedAt, $description, $content, $imgAltTag, $isActive, $id        
          );
          $stmt->execute();
          
          return new Post($id, $entity->getTitle(),$entity->getSlug(),$entity->getImgUrl(),$byId->getCreatedAt(),$entity->getPublishedAt(),$entity->getDescription(),$entity->getContent(),$entity->getImgAltTag(),$entity->getIsActive());
      
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

