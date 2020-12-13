<?php

namespace Kodbazis\Generated\Repository\Feedback;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Feedback\Patch\PatchedFeedback;
use Kodbazis\Generated\Feedback\Patch\Patcher;
use Kodbazis\Generated\Feedback\Feedback;
use mysqli;

class SqlPatcher implements Patcher
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function patch(string $id, PatchedFeedback $entity): Feedback
    {
        try {
          $byId = (new SqlByIdGetter($this->connection))->byId($id);
          $merged = $this->merge($byId, $entity);
          
          $stmt = $this->connection->prepare(
              'UPDATE `feedbacks` SET 
                `episodeId` = ?
                WHERE `id` = ?;'
          );
          
          call_user_func(function (...$params) use ($stmt) {
                $stmt->bind_param(
                    "is",
                    ...$params
                );
            },
                $merged->getEpisodeId(), $id);
          
          
          $stmt->execute();
          
          if ($stmt->error) {
              throw new OperationError($stmt->error);
          }
          
          return new Feedback($id, $byId->getName(),$byId->getContent(),$merged->getEpisodeId(),$byId->getCreatedAt());
      
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

    private function merge(Feedback $prev, PatchedFeedback $patched): PatchedFeedback
    {
        return new PatchedFeedback(
            $patched->getEpisodeId() !== null ? $patched->getEpisodeId() : $prev->getEpisodeId()
        );
    }
}

