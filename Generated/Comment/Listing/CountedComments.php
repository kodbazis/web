<?php

  namespace Kodbazis\Generated\Comment\Listing;

  use Kodbazis\Generated\Comment\Comment;

  class CountedComments
  {
      /**
      * @var Comment[]
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

  