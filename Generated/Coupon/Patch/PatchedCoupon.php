<?php

namespace Kodbazis\Generated\Coupon\Patch;

use JsonSerializable;

class PatchedCoupon implements JsonSerializable
{
    private $subscriberId;
private $isRedeemed;


    
public function __construct($subscriberId, $isRedeemed)
{
        $this->subscriberId = $subscriberId;
$this->isRedeemed = $isRedeemed;

}
    
    public function getSubscriberId(): ?int
    {
        return $this->subscriberId;
    }
    public function getIsRedeemed(): ?bool
    {
        return $this->isRedeemed;
    }
    
    
    public function jsonSerialize()
    {
        return [
            'subscriberId' => $this->subscriberId,
 'isRedeemed' => $this->isRedeemed,

        ];
    }
}
