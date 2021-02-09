<?php
      namespace Kodbazis\Generated\Quote\Listing;
      
      use Kodbazis\Generated\Listing\Query;
      
      interface Lister
      {
          function list(Query $query): CountedQuotes;
      }
    