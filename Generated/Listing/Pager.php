<?php

namespace Kodbazis\Generated\Listing;

interface Pager
{
    public function getPaging(int $limit, int $offset, string $path, int $total): array;
}

  