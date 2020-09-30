<?php

namespace Kodbazis\Generated\Route;

use Kodbazis\Generated\Request;
use mysqli;

interface RouterFn {
    public function getRoute(Request $request): string;
}

  