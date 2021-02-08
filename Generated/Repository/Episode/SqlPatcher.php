<?php

namespace Kodbazis\Generated\Repository\Episode;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Episode\Patch\PatchedEpisode;
use Kodbazis\Generated\Episode\Patch\Patcher;
use Kodbazis\Generated\Episode\Episode;
use mysqli;

class SqlPatcher implements Patcher
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function patch(string $id, PatchedEpisode $entity): Episode
    {
        try {
          $byId = (new SqlByIdGetter($this->connection))->byId($id);
          $merged = $this->merge($byId, $entity);
          
          $stmt = $this->connection->prepare(
              'UPDATE `episodes` SET 
                `title` = ?, `slug` = ?, `courseId` = ?, `imgUrl` = ?, `description` = ?, `shortDescription` = ?, `content` = ?, `position` = ?, `isActive` = ?, `isPreview` = ?
                WHERE `id` = ?;'
          );
          
          call_user_func(function (...$params) use ($stmt) {
                $stmt->bind_param(
                    "ssissssiiis",
                    ...$params
                );
            },
                $merged->getTitle(),
        $merged->getSlug(),
        $merged->getCourseId(),
        $merged->getImgUrl(),
        $merged->getDescription(),
        $merged->getShortDescription(),
        $merged->getContent(),
        $merged->getPosition(),
        $merged->getIsActive(),
        $merged->getIsPreview(), $id);
          
          
          $stmt->execute();
          
          if ($stmt->error) {
              throw new OperationError($stmt->error);
          }
          
          return new Episode($id, $merged->getTitle(),$merged->getSlug(),$merged->getCourseId(),$merged->getImgUrl(),$merged->getDescription(),$merged->getShortDescription(),$merged->getContent(),$byId->getCreatedAt(),$merged->getPosition(),$merged->getIsActive(),$merged->getIsPreview());
      
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

    private function merge(Episode $prev, PatchedEpisode $patched): PatchedEpisode
    {
        return new PatchedEpisode(
            $patched->getTitle() !== null ? $patched->getTitle() : $prev->getTitle(), $patched->getSlug() !== null ? $patched->getSlug() : $prev->getSlug(), $patched->getCourseId() !== null ? $patched->getCourseId() : $prev->getCourseId(), $patched->getImgUrl() !== null ? $patched->getImgUrl() : $prev->getImgUrl(), $patched->getDescription() !== null ? $patched->getDescription() : $prev->getDescription(), $patched->getShortDescription() !== null ? $patched->getShortDescription() : $prev->getShortDescription(), $patched->getContent() !== null ? $patched->getContent() : $prev->getContent(), $patched->getPosition() !== null ? $patched->getPosition() : $prev->getPosition(), $patched->getIsActive() !== null ? $patched->getIsActive() : $prev->getIsActive(), $patched->getIsPreview() !== null ? $patched->getIsPreview() : $prev->getIsPreview()
        );
    }
}

