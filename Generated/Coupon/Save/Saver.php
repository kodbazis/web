<?php
    namespace Kodbazis\Generated\Coupon\Save;

    use Kodbazis\Generated\Coupon\Coupon;

    interface Saver
    {
        function Save(NewCoupon $new): Coupon;
    }
    