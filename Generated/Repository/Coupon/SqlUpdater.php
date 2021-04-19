<?php

namespace Kodbazis\Generated\Repository\Coupon;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Coupon\Update\UpdatedCoupon;
use Kodbazis\Generated\Coupon\Update\Updater;
use Kodbazis\Generated\Coupon\Coupon;
use mysqli;

class SqlUpdater implements Updater
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function update(string $id, UpdatedCoupon $entity): Coupon
    {
        try {
          $byId = (new SqlByIdGetter($this->connection))->byId($id);
          
          $stmt = $this->connection->prepare(
              'UPDATE `coupons` SET 
                `subscriberId` = ?, `isRedeemed` = ?
                WHERE `id` = ?;'
          );
          
          $subscriberId= $entity->getSubscriberId();
        $isRedeemed= $entity->getIsRedeemed();
         
          $stmt->bind_param(
              "iis",
               $subscriberId, $isRedeemed, $id        
          );
          $stmt->execute();
          
          return new Coupon($id, $byId->getCourseId(),$entity->getSubscriberId(),$entity->getIsRedeemed(),$byId->getDiscount(),$byId->getIssuedTo(),$byId->getCode(),$byId->getValidUntil(),$byId->getCreatedAt());
      
      } catch (\Error $exception) {
          if ($_SERVER['DEPLOYMENT_ENV'] === 'dev') {
            var_dump($exception);
            exit;
          }
          throw new OperationError("update error");
      } catch (\Exception $exception) {
          if ($_SERVER['DEPLOYMENT_ENV'] === 'dev') {
            var_dump($exception);
            exit;
          }
          throw new OperationError("update error");
      }
    }
}

