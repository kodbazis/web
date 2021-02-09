<?php

namespace Kodbazis\Generated\Spec\Listing;

use JsonSerializable;
use Kodbazis\Generated\Listing\Paging;
use Kodbazis\Generated\Spec\Spec;

class Response implements JsonSerializable
{
    private $paging;

    /**
     * @var Spec[]
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
  