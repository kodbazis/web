<?php

  namespace Kodbazis\Generated\Coupon\Listing;

  use Kodbazis\Generated\Coupon\Coupon;

  class CountedCoupons
  {
      /**
      * @var Coupon[]
      */
      private $entities;
 
      private $count;
  
      public function __construct(array $entities, int $count)
      {
          $this->entities = $entities;
          $this->count = $count;
      }

      public function getEntities(): array
      {
          return $this->entities;
      }
  
      public function getCount(): int
      {
          return $this->count;
      }
  }

  