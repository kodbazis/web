<?php
      namespace Kodbazis\Generated\Episode\Listing;
      
      use Kodbazis\Generated\Listing\Query;
      
      interface Lister
      {
          function list(Query $query): CountedEpisodes;
      }
    