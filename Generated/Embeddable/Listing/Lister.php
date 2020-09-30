<?php
      namespace Kodbazis\Generated\Embeddable\Listing;
      
      use Kodbazis\Generated\Listing\Query;
      
      interface Lister
      {
          function list(Query $query): CountedEmbeddables;
      }
    