<?php

namespace Kodbazis\Generated\Repository\Coupon;

use mysqli;
use Kodbazis\Generated\Coupon\ById\ById;
use Kodbazis\Generated\Coupon\Coupon;
use Kodbazis\Generated\OperationError;

class SqlByIdGetter implements ById
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function byId(string $id): Coupon
    {
        try {
            $stmt = $this->connection->prepare('SELECT * FROM `coupons` WHERE id = ?');
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return new Coupon((int)$result['id'], (int)$result['courseId'], (int)$result['subscriberId'], (bool)$result['isRedeemed'], (int)$result['discount'], (int)$result['issuedTo'], (string)$result['code'], (int)$result['validUntil'], (int)$result['createdAt']);
        
        } catch (\Error $exception) {
            if ($_SERVER['DEPLOYMENT_ENV'] === 'dev') {
                var_dump($exception);
                exit;
            }
            throw new OperationError("by id error");
        } catch (\Exception $exception) {
            if ($_SERVER['DEPLOYMENT_ENV'] === 'dev') {
                var_dump($exception);
                exit;
            }
            throw new OperationError("by id error");
        }
    }
}

