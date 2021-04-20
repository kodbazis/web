<?php

namespace Kodbazis\Generated\Repository\Coupon;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Coupon\Patch\PatchedCoupon;
use Kodbazis\Generated\Coupon\Patch\Patcher;
use Kodbazis\Generated\Coupon\Coupon;
use mysqli;

class SqlPatcher implements Patcher
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function patch(string $id, PatchedCoupon $entity): Coupon
    {
        try {
          $byId = (new SqlByIdGetter($this->connection))->byId($id);
          $merged = $this->merge($byId, $entity);
          
          $stmt = $this->connection->prepare(
              'UPDATE `coupons` SET 
                `redeemedBy` = ?
                WHERE `id` = ?;'
          );
          
          call_user_func(function (...$params) use ($stmt) {
                $stmt->bind_param(
                    "is",
                    ...$params
                );
            },
                $merged->getRedeemedBy(), $id);
          
          
          $stmt->execute();
          
          if ($stmt->error) {
              throw new OperationError($stmt->error);
          }
          
          return new Coupon($id, $byId->getCourseId(),$byId->getIssuedTo(),$byId->getMailedAt(),$byId->getRef(),$merged->getRedeemedBy(),$byId->getDiscount(),$byId->getCode(),$byId->getValidUntil(),$byId->getCreatedAt());
      
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

    private function merge(Coupon $prev, PatchedCoupon $patched): PatchedCoupon
    {
        return new PatchedCoupon(
            $patched->getRedeemedBy() !== null ? $patched->getRedeemedBy() : $prev->getRedeemedBy()
        );
    }
}

