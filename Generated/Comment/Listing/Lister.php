<?php
      namespace Kodbazis\Generated\Comment\Listing;
      
      use Kodbazis\Generated\Listing\Query;
      
      interface Lister
      {
          function list(Query $query): CountedComments;
      }
    