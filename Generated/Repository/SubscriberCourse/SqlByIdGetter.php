<?php

namespace Kodbazis\Generated\Repository\SubscriberCourse;

use mysqli;
use Kodbazis\Generated\SubscriberCourse\ById\ById;
use Kodbazis\Generated\SubscriberCourse\SubscriberCourse;
use Kodbazis\Generated\OperationError;

class SqlByIdGetter implements ById
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function byId(string $id): SubscriberCourse
    {
        try {
            $stmt = $this->connection->prepare('SELECT * FROM `subscriberCourses` WHERE id = ?');
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return new SubscriberCourse((int)$result['id'], (int)$result['subscriberId'], (int)$result['courseId'], (string)$result['name'], (string)$result['taxNumber'], (int)$result['zip'], (string)$result['city'], (string)$result['address'], (string)$result['purchaseType'], (string)$result['orderRef'], (bool)$result['isPayed'], (bool)$result['isVerified'], (bool)$result['isInvoiceSent'], (int)$result['createdAt']);
        
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

