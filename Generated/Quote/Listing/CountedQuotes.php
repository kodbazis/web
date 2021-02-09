<?php

  namespace Kodbazis\Generated\Quote\Listing;

  use Kodbazis\Generated\Quote\Quote;

  class CountedQuotes
  {
      /**
      * @var Quote[]
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

  