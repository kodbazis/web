<?php
    namespace Kodbazis\Generated\Coupon\Update;
    
    use Kodbazis\Generated\Coupon\Coupon;
    
    interface Updater
    {
        function update(string $id, UpdatedCoupon $coupon): Coupon;
    }
    