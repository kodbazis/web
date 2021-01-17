<?php

namespace Kodbazis\Generated\Repository\SubscriberCourse;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\SubscriberCourse\Patch\PatchedSubscriberCourse;
use Kodbazis\Generated\SubscriberCourse\Patch\Patcher;
use Kodbazis\Generated\SubscriberCourse\SubscriberCourse;
use mysqli;

class SqlPatcher implements Patcher
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function patch(string $id, PatchedSubscriberCourse $entity): SubscriberCourse
    {
        try {
          $byId = (new SqlByIdGetter($this->connection))->byId($id);
          $merged = $this->merge($byId, $entity);
          
          $stmt = $this->connection->prepare(
              'UPDATE `subscriberCourses` SET 
                `name` = ?, `taxNumber` = ?, `zip` = ?, `city` = ?, `address` = ?, `purchaseType` = ?, `orderRef` = ?, `isPayed` = ?, `isVerified` = ?, `isInvoiceSent` = ?
                WHERE `id` = ?;'
          );
          
          call_user_func(function (...$params) use ($stmt) {
                $stmt->bind_param(
                    "ssissssiiis",
                    ...$params
                );
            },
                $merged->getName(),
        $merged->getTaxNumber(),
        $merged->getZip(),
        $merged->getCity(),
        $merged->getAddress(),
        $merged->getPurchaseType(),
        $merged->getOrderRef(),
        $merged->getIsPayed(),
        $merged->getIsVerified(),
        $merged->getIsInvoiceSent(), $id);
          
          
          $stmt->execute();
          
          if ($stmt->error) {
              throw new OperationError($stmt->error);
          }
          
          return new SubscriberCourse($id, $byId->getSubscriberId(),$byId->getCourseId(),$merged->getName(),$merged->getTaxNumber(),$merged->getZip(),$merged->getCity(),$merged->getAddress(),$merged->getPurchaseType(),$merged->getOrderRef(),$merged->getIsPayed(),$merged->getIsVerified(),$merged->getIsInvoiceSent(),$byId->getCreatedAt());
      
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

    private function merge(SubscriberCourse $prev, PatchedSubscriberCourse $patched): PatchedSubscriberCourse
    {
        return new PatchedSubscriberCourse(
            $patched->getName() !== null ? $patched->getName() : $prev->getName(), $patched->getTaxNumber() !== null ? $patched->getTaxNumber() : $prev->getTaxNumber(), $patched->getZip() !== null ? $patched->getZip() : $prev->getZip(), $patched->getCity() !== null ? $patched->getCity() : $prev->getCity(), $patched->getAddress() !== null ? $patched->getAddress() : $prev->getAddress(), $patched->getPurchaseType() !== null ? $patched->getPurchaseType() : $prev->getPurchaseType(), $patched->getOrderRef() !== null ? $patched->getOrderRef() : $prev->getOrderRef(), $patched->getIsPayed() !== null ? $patched->getIsPayed() : $prev->getIsPayed(), $patched->getIsVerified() !== null ? $patched->getIsVerified() : $prev->getIsVerified(), $patched->getIsInvoiceSent() !== null ? $patched->getIsInvoiceSent() : $prev->getIsInvoiceSent()
        );
    }
}

