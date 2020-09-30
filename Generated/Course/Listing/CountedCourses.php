<?php

  namespace Kodbazis\Generated\Course\Listing;

  use Kodbazis\Generated\Course\Course;

  class CountedCourses
  {
      /**
      * @var Course[]
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

  