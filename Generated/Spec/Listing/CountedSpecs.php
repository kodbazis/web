<?php

  namespace Kodbazis\Generated\Spec\Listing;

  use Kodbazis\Generated\Spec\Spec;

  class CountedSpecs
  {
      /**
      * @var Spec[]
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

  