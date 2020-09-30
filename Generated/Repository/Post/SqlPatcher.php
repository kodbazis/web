<?php

namespace Kodbazis\Generated\Repository\Post;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Post\Patch\PatchedPost;
use Kodbazis\Generated\Post\Patch\Patcher;
use Kodbazis\Generated\Post\Post;
use mysqli;

class SqlPatcher implements Patcher
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function patch(string $id, PatchedPost $entity): Post
    {
        try {
          $byId = (new SqlByIdGetter($this->connection))->byId($id);
          $merged = $this->merge($byId, $entity);
          
          $stmt = $this->connection->prepare(
              'UPDATE `posts` SET 
                `title` = ?, `slug` = ?, `imgUrl` = ?, `publishedAt` = ?, `description` = ?, `content` = ?, `imgAltTag` = ?, `isActive` = ?
                WHERE `id` = ?;'
          );
          
          call_user_func(function (...$params) use ($stmt) {
                $stmt->bind_param(
                    "sssisssis",
                    ...$params
                );
            },
                $merged->getTitle(),
        $merged->getSlug(),
        $merged->getImgUrl(),
        $merged->getPublishedAt(),
        $merged->getDescription(),
        $merged->getContent(),
        $merged->getImgAltTag(),
        $merged->getIsActive(), $id);
          
          
          $stmt->execute();
          
          if ($stmt->error) {
              throw new OperationError($stmt->error);
          }
          
          return new Post($id, $merged->getTitle(),$merged->getSlug(),$merged->getImgUrl(),$byId->getCreatedAt(),$merged->getPublishedAt(),$merged->getDescription(),$merged->getContent(),$merged->getImgAltTag(),$merged->getIsActive());
      
      } catch (\Error $exception) {
            if ($_SERVER['DEPLOYMENT_ENV'] === 'dev') {
                var_dump($exception);
                exit;
            }
          throw new OperationError("patch error");
      } catch (\Exception $exception) {
            if ($_SERVER['DEPLOYMENT_ENV'] === 'dev') {
                var_dump($exception);
                exit;
            }
          throw new OperationError("patch error");
      }
    }

    private function merge(Post $prev, PatchedPost $patched): PatchedPost
    {
        return new PatchedPost(
            $patched->getTitle() !== null ? $patched->getTitle() : $prev->getTitle(), $patched->getSlug() !== null ? $patched->getSlug() : $prev->getSlug(), $patched->getImgUrl() !== null ? $patched->getImgUrl() : $prev->getImgUrl(), $patched->getPublishedAt() !== null ? $patched->getPublishedAt() : $prev->getPublishedAt(), $patched->getDescription() !== null ? $patched->getDescription() : $prev->getDescription(), $patched->getContent() !== null ? $patched->getContent() : $prev->getContent(), $patched->getImgAltTag() !== null ? $patched->getImgAltTag() : $prev->getImgAltTag(), $patched->getIsActive() !== null ? $patched->getIsActive() : $prev->getIsActive()
        );
    }
}

