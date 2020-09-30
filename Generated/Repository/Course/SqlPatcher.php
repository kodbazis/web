<?php

namespace Kodbazis\Generated\Repository\Course;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Course\Patch\PatchedCourse;
use Kodbazis\Generated\Course\Patch\Patcher;
use Kodbazis\Generated\Course\Course;
use mysqli;

class SqlPatcher implements Patcher
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function patch(string $id, PatchedCourse $entity): Course
    {
        try {
          $byId = (new SqlByIdGetter($this->connection))->byId($id);
          $merged = $this->merge($byId, $entity);
          
          $stmt = $this->connection->prepare(
              'UPDATE `courses` SET 
                `title` = ?, `slug` = ?, `imgUrl` = ?, `description` = ?, `videoUrl` = ?, `isActive` = ?
                WHERE `id` = ?;'
          );
          
          call_user_func(function (...$params) use ($stmt) {
                $stmt->bind_param(
                    "sssssis",
                    ...$params
                );
            },
                $merged->getTitle(),
        $merged->getSlug(),
        $merged->getImgUrl(),
        $merged->getDescription(),
        $merged->getVideoUrl(),
        $merged->getIsActive(), $id);
          
          
          $stmt->execute();
          
          if ($stmt->error) {
              throw new OperationError($stmt->error);
          }
          
          return new Course($id, $merged->getTitle(),$merged->getSlug(),$merged->getImgUrl(),$merged->getDescription(),$merged->getVideoUrl(),$byId->getCreatedAt(),$merged->getIsActive());
      
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

    private function merge(Course $prev, PatchedCourse $patched): PatchedCourse
    {
        return new PatchedCourse(
            $patched->getTitle() !== null ? $patched->getTitle() : $prev->getTitle(), $patched->getSlug() !== null ? $patched->getSlug() : $prev->getSlug(), $patched->getImgUrl() !== null ? $patched->getImgUrl() : $prev->getImgUrl(), $patched->getDescription() !== null ? $patched->getDescription() : $prev->getDescription(), $patched->getVideoUrl() !== null ? $patched->getVideoUrl() : $prev->getVideoUrl(), $patched->getIsActive() !== null ? $patched->getIsActive() : $prev->getIsActive()
        );
    }
}

