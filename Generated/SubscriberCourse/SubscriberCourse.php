<?php

namespace Kodbazis\Generated\SubscriberCourse;

use JsonSerializable;

class SubscriberCourse implements JsonSerializable
{
    private $id;
private $subscriberId;
private $courseId;
private $name;
private $taxNumber;
private $zip;
private $city;
private $address;
private $purchaseType;
private $orderRef;
private $isPayed;
private $isVerified;
private $isInvoiceSent;
private $createdAt;


    
public function __construct($id, $subscriberId, $courseId, $name, $taxNumber, $zip, $city, $address, $purchaseType, $orderRef, $isPayed, $isVerified, $isInvoiceSent, $createdAt)
{
        $this->id = $id;
$this->subscriberId = $subscriberId;
$this->courseId = $courseId;
$this->name = $name;
$this->taxNumber = $taxNumber;
$this->zip = $zip;
$this->city = $city;
$this->address = $address;
$this->purchaseType = $purchaseType;
$this->orderRef = $orderRef;
$this->isPayed = $isPayed;
$this->isVerified = $isVerified;
$this->isInvoiceSent = $isInvoiceSent;
$this->createdAt = $createdAt;

}
    
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getSubscriberId(): ?int
    {
        return $this->subscriberId;
    }
    public function getCourseId(): ?int
    {
        return $this->courseId;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    public function getTaxNumber(): ?string
    {
        return $this->taxNumber;
    }
    public function getZip(): ?int
    {
        return $this->zip;
    }
    public function getCity(): ?string
    {
        return $this->city;
    }
    public function getAddress(): ?string
    {
        return $this->address;
    }
    public function getPurchaseType(): ?string
    {
        return $this->purchaseType;
    }
    public function getOrderRef(): ?string
    {
        return $this->orderRef;
    }
    public function getIsPayed(): ?bool
    {
        return $this->isPayed;
    }
    public function getIsVerified(): ?bool
    {
        return $this->isVerified;
    }
    public function getIsInvoiceSent(): ?bool
    {
        return $this->isInvoiceSent;
    }
    public function getCreatedAt(): ?int
    {
        return $this->createdAt;
    }
    
    
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
 'subscriberId' => $this->subscriberId,
 'courseId' => $this->courseId,
 'name' => $this->name,
 'taxNumber' => $this->taxNumber,
 'zip' => $this->zip,
 'city' => $this->city,
 'address' => $this->address,
 'purchaseType' => $this->purchaseType,
 'orderRef' => $this->orderRef,
 'isPayed' => $this->isPayed,
 'isVerified' => $this->isVerified,
 'isInvoiceSent' => $this->isInvoiceSent,
 'createdAt' => $this->createdAt,

        ];
    }
}
