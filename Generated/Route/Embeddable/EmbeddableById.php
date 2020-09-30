<?php

namespace Kodbazis\Generated\Route\Embeddable;

use Kodbazis\Generated\Embeddable\ById\ByIdController;
use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Repository\Embeddable\SqlByIdGetter;
use Kodbazis\Generated\Route\RouterFn;
use Kodbazis\Generated\Repository\Auth\JwtTokenVerifier;
use Kodbazis\Generated\Route\Auth\AuthHeaderParser;
use Kodbazis\Generated\Request;
use mysqli;

class EmbeddableById implements RouterFn
{
    public function getRoute(Request $request): string
    {
        

        return json_encode((new ByIdController(
            new SqlByIdGetter($request->connection),
            new OperationError())
        )
            ->byId($request->vars['id']), JSON_UNESCAPED_UNICODE);
    }
}

  