<?php

namespace Kodbazis\Generated\Quote\Listing;

use JsonSerializable;
use Kodbazis\Generated\Listing\Paging;
use Kodbazis\Generated\Quote\Quote;

class Response implements JsonSerializable
{
    private $paging;

    /**
     * @var Quote[]
     */
    private $results;
    
    public function __construct(Paging $paging, array $results)
    {
        $this->paging = $paging;
        $this->results = $results;
    }


    public function getPaging(): Paging
    {
        return $this->paging;
    }

    public function getResults(): array
    {
        return $this->results;
    }

    public function jsonSerialize()
    {
        return [
            'paging' => $this->paging,
            'results' => $this->results,
        ];
    }
}
  