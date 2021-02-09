<?php

namespace Kodbazis\Generated\Route\Spec;

use Kodbazis\Generated\Spec\Delete\DeleteController;
use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Repository\Spec\SqlDeleter;
use Kodbazis\Generated\Route\RouterFn;
use Kodbazis\Generated\Repository\Auth\JwtTokenVerifier;
use Kodbazis\Generated\Route\Auth\AuthHeaderParser;
use Kodbazis\Generated\Request;
use mysqli;

class SpecDeleter implements RouterFn
{
    public function getRoute(Request $request): string
    {
         

        header("Content-Type: application/json");
        return json_encode(['id' => (new DeleteController(
            new OperationError(),
            new SqlDeleter($request->connection))
        )
            ->delete($request->vars['id'])], JSON_UNESCAPED_UNICODE);
    }
}
  