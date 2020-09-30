<?php

namespace Kodbazis\Generated\Repository\Embeddable;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Embeddable\Patch\PatchedEmbeddable;
use Kodbazis\Generated\Embeddable\Patch\Patcher;
use Kodbazis\Generated\Embeddable\Embeddable;
use mysqli;

class SqlPatcher implements Patcher
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function patch(string $id, PatchedEmbeddable $entity): Embeddable
    {
        try {
          $byId = (new SqlByIdGetter($this->connection))->byId($id);
          $merged = $this->merge($byId, $entity);
          
          $stmt = $this->connection->prepare(
              'UPDATE `embeddables` SET 
                `name` = ?, `raw` = ?, `type` = ?
                WHERE `id` = ?;'
          );
          
          call_user_func(function (...$params) use ($stmt) {
                $stmt->bind_param(
                    "ssss",
                    ...$params
                );
            },
                $merged->getName(),
        $merged->getRaw(),
        $merged->getType(), $id);
          
          
          $stmt->execute();
          
          if ($stmt->error) {
              throw new OperationError($stmt->error);
          }
          
          return new Embeddable($id, $byId->getCreatedAt(),$merged->getName(),$merged->getRaw(),$merged->getType());
      
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

    private function merge(Embeddable $prev, PatchedEmbeddable $patched): PatchedEmbeddable
    {
        return new PatchedEmbeddable(
            $patched->getName() !== null ? $patched->getName() : $prev->getName(), $patched->getRaw() !== null ? $patched->getRaw() : $prev->getRaw(), $patched->getType() !== null ? $patched->getType() : $prev->getType()
        );
    }
}

