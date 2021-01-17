<?php

namespace Kodbazis\Generated\Repository\SubscriberCourse;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\SubscriberCourse\Update\UpdatedSubscriberCourse;
use Kodbazis\Generated\SubscriberCourse\Update\Updater;
use Kodbazis\Generated\SubscriberCourse\SubscriberCourse;
use mysqli;

class SqlUpdater implements Updater
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function update(string $id, UpdatedSubscriberCourse $entity): SubscriberCourse
    {
        try {
          $byId = (new SqlByIdGetter($this->connection))->byId($id);
          
          $stmt = $this->connection->prepare(
              'UPDATE `subscriberCourses` SET 
                `name` = ?, `taxNumber` = ?, `zip` = ?, `city` = ?, `address` = ?, `purchaseType` = ?, `orderRef` = ?, `isPayed` = ?, `isVerified` = ?, `isInvoiceSent` = ?
                WHERE `id` = ?;'
          );
          
          $name= $entity->getName();
        $taxNumber= $entity->getTaxNumber();
        $zip= $entity->getZip();
        $city= $entity->getCity();
        $address= $entity->getAddress();
        $purchaseType= $entity->getPurchaseType();
        $orderRef= $entity->getOrderRef();
        $isPayed= $entity->getIsPayed();
        $isVerified= $entity->getIsVerified();
        $isInvoiceSent= $entity->getIsInvoiceSent();
         
          $stmt->bind_param(
              "ssissssiiis",
               $name, $taxNumber, $zip, $city, $address, $purchaseType, $orderRef, $isPayed, $isVerified, $isInvoiceSent, $id        
          );
          $stmt->execute();
          
          return new SubscriberCourse($id, $byId->getSubscriberId(),$byId->getCourseId(),$entity->getName(),$entity->getTaxNumber(),$entity->getZip(),$entity->getCity(),$entity->getAddress(),$entity->getPurchaseType(),$entity->getOrderRef(),$entity->getIsPayed(),$entity->getIsVerified(),$entity->getIsInvoiceSent(),$byId->getCreatedAt());
      
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

