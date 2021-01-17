<?php
      namespace Kodbazis\Generated\SubscriberCourse\Listing;
      
      use Kodbazis\Generated\Listing\Query;
      
      interface Lister
      {
          function list(Query $query): CountedSubscriberCourses;
      }
    