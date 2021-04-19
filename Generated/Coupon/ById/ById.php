<?php
    namespace Kodbazis\Generated\Coupon\ById;
    
    use Kodbazis\Generated\Coupon\Coupon;
    
    interface ById
    {
        function byId(string $id): Coupon;
    }
    