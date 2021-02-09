<?php
      namespace Kodbazis\Generated\Spec\Listing;
      
      use Kodbazis\Generated\Listing\Query;
      
      interface Lister
      {
          function list(Query $query): CountedSpecs;
      }
    