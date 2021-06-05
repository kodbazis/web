<?php

namespace Kodbazis\Generated\Route\Message;

use Kodbazis\Generated\Message\ById\ByIdController;
use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Repository\Message\SqlByIdGetter;
use Kodbazis\Generated\Route\RouterFn;
use Kodbazis\Generated\Repository\Auth\JwtTokenVerifier;
use Kodbazis\Generated\Route\Auth\AuthHeaderParser;
use Kodbazis\Generated\Request;
use mysqli;

class MessageById implements RouterFn
{
    public function getRoute(Request $request): string
    {
        

        header("Content-Type: application/json");
        return json_encode((new ByIdController(
            new SqlByIdGetter($request->connection),
            new OperationError())
        )
            ->byId($request->vars['id']), JSON_UNESCAPED_UNICODE);
    }
}

  