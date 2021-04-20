<?php

namespace Kodbazis\Generated\Coupon\Patch;

use JsonSerializable;

class PatchedCoupon implements JsonSerializable
{
    private $redeemedBy;


    
public function __construct($redeemedBy)
{
        $this->redeemedBy = $redeemedBy;

}
    
    public function getRedeemedBy(): ?int
    {
        return $this->redeemedBy;
    }
    
    
    public function jsonSerialize()
    {
        return [
            'redeemedBy' => $this->redeemedBy,

        ];
    }
}
