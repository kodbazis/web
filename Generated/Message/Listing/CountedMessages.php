<?php

  namespace Kodbazis\Generated\Message\Listing;

  use Kodbazis\Generated\Message\Message;

  class CountedMessages
  {
      /**
      * @var Message[]
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

  