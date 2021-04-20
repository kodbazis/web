<?php

namespace Kodbazis\Generated\Coupon\Update;

use JsonSerializable;

class UpdatedCoupon implements JsonSerializable
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
