<?php

namespace Kodbazis\Generated\Repository\Comment;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Comment\Patch\PatchedComment;
use Kodbazis\Generated\Comment\Patch\Patcher;
use Kodbazis\Generated\Comment\Comment;
use mysqli;

class SqlPatcher implements Patcher
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function patch(string $id, PatchedComment $entity): Comment
    {
        try {
          $byId = (new SqlByIdGetter($this->connection))->byId($id);
          $merged = $this->merge($byId, $entity);
          
          $stmt = $this->connection->prepare(
              'UPDATE `comments` SET 
                
                WHERE `id` = ?;'
          );
          
          call_user_func(function (...$params) use ($stmt) {
                $stmt->bind_param(
                    "s",
                    ...$params
                );
            },
                , $id);
          
          
          $stmt->execute();
          
          if ($stmt->error) {
              throw new OperationError($stmt->error);
          }
          
          return new Comment($id, $byId->getContent(),$byId->getEmbeddableId(),$byId->getKey(),$byId->getCreatedAt());
      
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

    private function merge(Comment $prev, PatchedComment $patched): PatchedComment
    {
        return new PatchedComment(
            
        );
    }
}

