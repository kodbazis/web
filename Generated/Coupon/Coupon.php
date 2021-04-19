<?php

namespace Kodbazis\Generated\Coupon;

use JsonSerializable;

class Coupon implements JsonSerializable
{
    private $id;
private $courseId;
private $subscriberId;
private $isRedeemed;
private $discount;
private $issuedTo;
private $code;
private $validUntil;
private $createdAt;


    
public function __construct($id, $courseId, $subscriberId, $isRedeemed, $discount, $issuedTo, $code, $validUntil, $createdAt)
{
        $this->id = $id;
$this->courseId = $courseId;
$this->subscriberId = $subscriberId;
$this->isRedeemed = $isRedeemed;
$this->discount = $discount;
$this->issuedTo = $issuedTo;
$this->code = $code;
$this->validUntil = $validUntil;
$this->createdAt = $createdAt;

}
    
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getCourseId(): ?int
    {
        return $this->courseId;
    }
    public function getSubscriberId(): ?int
    {
        return $this->subscriberId;
    }
    public function getIsRedeemed(): ?bool
    {
        return $this->isRedeemed;
    }
    public function getDiscount(): ?int
    {
        return $this->discount;
    }
    public function getIssuedTo(): ?int
    {
        return $this->issuedTo;
    }
    public function getCode(): ?string
    {
        return $this->code;
    }
    public function getValidUntil(): ?int
    {
        return $this->validUntil;
    }
    public function getCreatedAt(): ?int
    {
        return $this->createdAt;
    }
    
    
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
 'courseId' => $this->courseId,
 'subscriberId' => $this->subscriberId,
 'isRedeemed' => $this->isRedeemed,
 'discount' => $this->discount,
 'issuedTo' => $this->issuedTo,
 'code' => $this->code,
 'validUntil' => $this->validUntil,
 'createdAt' => $this->createdAt,

        ];
    }
}
