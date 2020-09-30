<?php

  namespace Kodbazis\Generated\Post\Listing;

  use Kodbazis\Generated\Post\Post;

  class CountedPosts
  {
      /**
      * @var Post[]
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

  