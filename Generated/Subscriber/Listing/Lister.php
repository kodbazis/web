<?php
      namespace Kodbazis\Generated\Subscriber\Listing;
      
      use Kodbazis\Generated\Listing\Query;
      
      interface Lister
      {
          function list(Query $query): CountedSubscribers;
      }
    