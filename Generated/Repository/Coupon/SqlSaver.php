<?php

namespace Kodbazis\Generated\Repository\Coupon;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Coupon\Save\NewCoupon;
use Kodbazis\Generated\Coupon\Save\Saver;
use Kodbazis\Generated\Coupon\Coupon;
use mysqli;

class SqlSaver implements Saver
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function Save(NewCoupon $new): Coupon
    {
        try {
            $statement = $this->connection->prepare(
                "INSERT INTO `coupons` (
                `id`, `courseId`, `issuedTo`, `mailedAt`, `ref`, `redeemedBy`, `discount`, `code`, `validUntil`, `createdAt`
                ) 
                VALUES (NULL, ?,?,?,?,?,?,?,?,?);"
            );
    
            $courseId = $new->getCourseId();
        $issuedTo = $new->getIssuedTo();
        $mailedAt = $new->getMailedAt();
        $ref = $new->getRef();
        $redeemedBy = $new->getRedeemedBy();
        $discount = $new->getDiscount();
        $code = $new->getCode();
        $validUntil = $new->getValidUntil();
        $createdAt = $new->getCreatedAt();
        
    
            $statement->bind_param(
                "iiisiisii",
                 $courseId, $issuedTo, $mailedAt, $ref, $redeemedBy, $discount, $code, $validUntil, $createdAt        
             );
            $statement->execute();
    
            return new Coupon((string)$statement->insert_id, $new->getCourseId(),$new->getIssuedTo(),$new->getMailedAt(),$new->getRef(),$new->getRedeemedBy(),$new->getDiscount(),$new->getCode(),$new->getValidUntil(),$new->getCreatedAt());
        } catch (\Error $exception) {
            if ($_SERVER['DEPLOYMENT_ENV'] === 'dev') {
                var_dump($exception);
                exit;
            }
            throw new OperationError("save error");
        } catch (\Exception $exception) {
            if ($_SERVER['DEPLOYMENT_ENV'] === 'dev') {
                var_dump($exception);
                exit;
            }
            throw new OperationError("save error");
        }
    }
}

