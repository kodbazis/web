<?php

  namespace Kodbazis\Generated\SubscriberCourse\Listing;

  use Kodbazis\Generated\SubscriberCourse\SubscriberCourse;

  class CountedSubscriberCourses
  {
      /**
      * @var SubscriberCourse[]
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

  