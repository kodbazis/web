<?php
      namespace Kodbazis\Generated\Coupon\Listing;
      
      use Kodbazis\Generated\Listing\Query;
      
      interface Lister
      {
          function list(Query $query): CountedCoupons;
      }
    