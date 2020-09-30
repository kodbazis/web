<?php

  namespace Kodbazis\Generated\Episode\Listing;

  use Kodbazis\Generated\Episode\Episode;

  class CountedEpisodes
  {
      /**
      * @var Episode[]
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

  