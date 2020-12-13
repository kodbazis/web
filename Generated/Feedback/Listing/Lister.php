<?php
      namespace Kodbazis\Generated\Feedback\Listing;
      
      use Kodbazis\Generated\Listing\Query;
      
      interface Lister
      {
          function list(Query $query): CountedFeedbacks;
      }
    