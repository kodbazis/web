<?php
      namespace Kodbazis\Generated\Post\Listing;
      
      use Kodbazis\Generated\Listing\Query;
      
      interface Lister
      {
          function list(Query $query): CountedPosts;
      }
    