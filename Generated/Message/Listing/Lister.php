<?php
      namespace Kodbazis\Generated\Message\Listing;
      
      use Kodbazis\Generated\Listing\Query;
      
      interface Lister
      {
          function list(Query $query): CountedMessages;
      }
    