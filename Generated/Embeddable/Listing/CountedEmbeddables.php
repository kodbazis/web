<?php

  namespace Kodbazis\Generated\Embeddable\Listing;

  use Kodbazis\Generated\Embeddable\Embeddable;

  class CountedEmbeddables
  {
      /**
      * @var Embeddable[]
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

  