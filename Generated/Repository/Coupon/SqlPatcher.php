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
                `subscriberId` = ?, `isRedeemed` = ?
                WHERE `id` = ?;'
          );
          
          call_user_func(function (...$params) use ($stmt) {
                $stmt->bind_param(
                    "iis",
                    ...$params
                );
            },
                $merged->getSubscriberId(),
        $merged->getIsRedeemed(), $id);
          
          
          $stmt->execute();
          
          if ($stmt->error) {
              throw new OperationError($stmt->error);
          }
          
          return new Coupon($id, $byId->getCourseId(),$merged->getSubscriberId(),$merged->getIsRedeemed(),$byId->getDiscount(),$byId->getIssuedTo(),$byId->getCode(),$byId->getValidUntil(),$byId->getCreatedAt());
      
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
            $patched->getSubscriberId() !== null ? $patched->getSubscriberId() : $prev->getSubscriberId(), $patched->getIsRedeemed() !== null ? $patched->getIsRedeemed() : $prev->getIsRedeemed()
        );
    }
}

