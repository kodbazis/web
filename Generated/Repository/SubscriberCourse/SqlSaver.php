<?php

namespace Kodbazis\Generated\Repository\SubscriberCourse;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\SubscriberCourse\Save\NewSubscriberCourse;
use Kodbazis\Generated\SubscriberCourse\Save\Saver;
use Kodbazis\Generated\SubscriberCourse\SubscriberCourse;
use mysqli;

class SqlSaver implements Saver
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function Save(NewSubscriberCourse $new): SubscriberCourse
    {
        try {
            $statement = $this->connection->prepare(
                "INSERT INTO `subscriberCourses` (
                `id`, `subscriberId`, `courseId`, `name`, `taxNumber`, `zip`, `city`, `address`, `purchaseType`, `orderRef`, `isPayed`, `isVerified`, `isInvoiceSent`, `createdAt`
                ) 
                VALUES (NULL, ?,?,?,?,?,?,?,?,?,?,?,?,?);"
            );
    
            $subscriberId = $new->getSubscriberId();
        $courseId = $new->getCourseId();
        $name = $new->getName();
        $taxNumber = $new->getTaxNumber();
        $zip = $new->getZip();
        $city = $new->getCity();
        $address = $new->getAddress();
        $purchaseType = $new->getPurchaseType();
        $orderRef = $new->getOrderRef();
        $isPayed = $new->getIsPayed();
        $isVerified = $new->getIsVerified();
        $isInvoiceSent = $new->getIsInvoiceSent();
        $createdAt = $new->getCreatedAt();
        
    
            $statement->bind_param(
                "iississssiiii",
                 $subscriberId, $courseId, $name, $taxNumber, $zip, $city, $address, $purchaseType, $orderRef, $isPayed, $isVerified, $isInvoiceSent, $createdAt        
             );
            $statement->execute();
    
            return new SubscriberCourse((string)$statement->insert_id, $new->getSubscriberId(),$new->getCourseId(),$new->getName(),$new->getTaxNumber(),$new->getZip(),$new->getCity(),$new->getAddress(),$new->getPurchaseType(),$new->getOrderRef(),$new->getIsPayed(),$new->getIsVerified(),$new->getIsInvoiceSent(),$new->getCreatedAt());
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

