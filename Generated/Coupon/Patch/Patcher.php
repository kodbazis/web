<?php
    namespace Kodbazis\Generated\Coupon\Patch;
    
    use Kodbazis\Generated\Coupon\Coupon;
    
    interface Patcher
    {
        function patch(string $id, PatchedCoupon $coupon): Coupon;
    }
    