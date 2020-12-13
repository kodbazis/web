<?php

  namespace Kodbazis\Generated\Feedback\Listing;

  use Kodbazis\Generated\Feedback\Feedback;

  class CountedFeedbacks
  {
      /**
      * @var Feedback[]
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

  