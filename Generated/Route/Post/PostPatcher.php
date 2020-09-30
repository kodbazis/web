<?php

namespace Kodbazis\Generated\Route\Post;

use Kodbazis\Generated\Post\Patch\PatchController;
use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Repository\Post\SqlPatcher;
use Kodbazis\Generated\ValidationError;
use Kodbazis\Generated\Route\RouterFn;
use Kodbazis\Generated\Repository\Auth\JwtTokenVerifier;
use Kodbazis\Generated\Route\Auth\AuthHeaderParser;
use Kodbazis\Generated\Request;
use mysqli;

class PostPatcher implements RouterFn
{
    public function getRoute(Request $request): string
    {
       

        return json_encode((new PatchController(
            new SqlPatcher($request->connection),
            new OperationError(),
            new ValidationError()
        ))
            ->patch($request->body ?? [], $request->vars['id']), JSON_UNESCAPED_UNICODE);
    }
}

  