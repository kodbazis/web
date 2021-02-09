<?php

namespace Kodbazis\Generated\Repository\Spec;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Spec\Patch\PatchedSpec;
use Kodbazis\Generated\Spec\Patch\Patcher;
use Kodbazis\Generated\Spec\Spec;
use mysqli;

class SqlPatcher implements Patcher
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function patch(string $id, PatchedSpec $entity): Spec
    {
        try {
          $byId = (new SqlByIdGetter($this->connection))->byId($id);
          $merged = $this->merge($byId, $entity);
          
          $stmt = $this->connection->prepare(
              'UPDATE `specs` SET 
                `content` = ?, `position` = ?, `courseId` = ?
                WHERE `id` = ?;'
          );
          
          call_user_func(function (...$params) use ($stmt) {
                $stmt->bind_param(
                    "siis",
                    ...$params
                );
            },
                $merged->getContent(),
        $merged->getPosition(),
        $merged->getCourseId(), $id);
          
          
          $stmt->execute();
          
          if ($stmt->error) {
              throw new OperationError($stmt->error);
          }
          
          return new Spec($id, $merged->getContent(),$merged->getPosition(),$merged->getCourseId(),$byId->getCreatedAt());
      
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

    private function merge(Spec $prev, PatchedSpec $patched): PatchedSpec
    {
        return new PatchedSpec(
            $patched->getContent() !== null ? $patched->getContent() : $prev->getContent(), $patched->getPosition() !== null ? $patched->getPosition() : $prev->getPosition(), $patched->getCourseId() !== null ? $patched->getCourseId() : $prev->getCourseId()
        );
    }
}

