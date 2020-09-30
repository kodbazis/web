<?php

namespace Kodbazis\Generated\Route\Post;

use Kodbazis\Generated\Post\Delete\DeleteController;
use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Repository\Post\SqlDeleter;
use Kodbazis\Generated\Route\RouterFn;
use Kodbazis\Generated\Repository\Auth\JwtTokenVerifier;
use Kodbazis\Generated\Route\Auth\AuthHeaderParser;
use Kodbazis\Generated\Request;
use mysqli;

class PostDeleter implements RouterFn
{
    public function getRoute(Request $request): string
    {
         

        return json_encode(['id' => (new DeleteController(
            new OperationError(),
            new SqlDeleter($request->connection))
        )
            ->delete($request->vars['id'])], JSON_UNESCAPED_UNICODE);
    }
}
  