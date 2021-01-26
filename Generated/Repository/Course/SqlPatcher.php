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
                `title` = ?, `invoiceTitle` = ?, `content` = ?, `slug` = ?, `imgUrl` = ?, `videoId` = ?, `description` = ?, `isActive` = ?, `price` = ?, `discount` = ?
                WHERE `id` = ?;'
          );
          
          call_user_func(function (...$params) use ($stmt) {
                $stmt->bind_param(
                    "sssssssiiis",
                    ...$params
                );
            },
                $merged->getTitle(),
        $merged->getInvoiceTitle(),
        $merged->getContent(),
        $merged->getSlug(),
        $merged->getImgUrl(),
        $merged->getVideoId(),
        $merged->getDescription(),
        $merged->getIsActive(),
        $merged->getPrice(),
        $merged->getDiscount(), $id);
          
          
          $stmt->execute();
          
          if ($stmt->error) {
              throw new OperationError($stmt->error);
          }
          
          return new Course($id, $merged->getTitle(),$merged->getInvoiceTitle(),$merged->getContent(),$merged->getSlug(),$merged->getImgUrl(),$merged->getVideoId(),$merged->getDescription(),$byId->getCreatedAt(),$merged->getIsActive(),$merged->getPrice(),$merged->getDiscount());
      
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
            $patched->getTitle() !== null ? $patched->getTitle() : $prev->getTitle(), $patched->getInvoiceTitle() !== null ? $patched->getInvoiceTitle() : $prev->getInvoiceTitle(), $patched->getContent() !== null ? $patched->getContent() : $prev->getContent(), $patched->getSlug() !== null ? $patched->getSlug() : $prev->getSlug(), $patched->getImgUrl() !== null ? $patched->getImgUrl() : $prev->getImgUrl(), $patched->getVideoId() !== null ? $patched->getVideoId() : $prev->getVideoId(), $patched->getDescription() !== null ? $patched->getDescription() : $prev->getDescription(), $patched->getIsActive() !== null ? $patched->getIsActive() : $prev->getIsActive(), $patched->getPrice() !== null ? $patched->getPrice() : $prev->getPrice(), $patched->getDiscount() !== null ? $patched->getDiscount() : $prev->getDiscount()
        );
    }
}

