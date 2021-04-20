<?php

namespace Kodbazis\Generated\Coupon;

use JsonSerializable;

class Coupon implements JsonSerializable
{
    private $id;
private $courseId;
private $issuedTo;
private $mailedAt;
private $ref;
private $redeemedBy;
private $discount;
private $code;
private $validUntil;
private $createdAt;


    
public function __construct($id, $courseId, $issuedTo, $mailedAt, $ref, $redeemedBy, $discount, $code, $validUntil, $createdAt)
{
        $this->id = $id;
$this->courseId = $courseId;
$this->issuedTo = $issuedTo;
$this->mailedAt = $mailedAt;
$this->ref = $ref;
$this->redeemedBy = $redeemedBy;
$this->discount = $discount;
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
    public function getIssuedTo(): ?int
    {
        return $this->issuedTo;
    }
    public function getMailedAt(): ?int
    {
        return $this->mailedAt;
    }
    public function getRef(): ?string
    {
        return $this->ref;
    }
    public function getRedeemedBy(): ?int
    {
        return $this->redeemedBy;
    }
    public function getDiscount(): ?int
    {
        return $this->discount;
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
 'issuedTo' => $this->issuedTo,
 'mailedAt' => $this->mailedAt,
 'ref' => $this->ref,
 'redeemedBy' => $this->redeemedBy,
 'discount' => $this->discount,
 'code' => $this->code,
 'validUntil' => $this->validUntil,
 'createdAt' => $this->createdAt,

        ];
    }
}
