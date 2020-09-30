<?php
      namespace Kodbazis\Generated\Course\Listing;
      
      use Kodbazis\Generated\Listing\Query;
      
      interface Lister
      {
          function list(Query $query): CountedCourses;
      }
    