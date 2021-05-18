<?php

namespace Kodbazis\Generated\Repository\Quote;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Quote\Patch\PatchedQuote;
use Kodbazis\Generated\Quote\Patch\Patcher;
use Kodbazis\Generated\Quote\Quote;
use mysqli;

class SqlPatcher implements Patcher
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function patch(string $id, PatchedQuote $entity): Quote
    {
        try {
          $byId = (new SqlByIdGetter($this->connection))->byId($id);
          $merged = $this->merge($byId, $entity);
          
          $stmt = $this->connection->prepare(
              'UPDATE `quotes` SET 
                `position` = ?, `courseId` = ?
                WHERE `id` = ?;'
          );
          
          call_user_func(function (...$params) use ($stmt) {
                $stmt->bind_param(
                    "iis",
                    ...$params
                );
            },
                $merged->getPosition(),
        $merged->getCourseId(), $id);
          
          
          $stmt->execute();
          
          if ($stmt->error) {
              throw new OperationError($stmt->error);
          }
          
          return new Quote($id, $byId->getContent(),$byId->getAuthor(),$merged->getPosition(),$merged->getCourseId(),$byId->getRating(),$byId->getCreatedAt());
      
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

    private function merge(Quote $prev, PatchedQuote $patched): PatchedQuote
    {
        return new PatchedQuote(
            $patched->getPosition() !== null ? $patched->getPosition() : $prev->getPosition(), $patched->getCourseId() !== null ? $patched->getCourseId() : $prev->getCourseId()
        );
    }
}

