<?php

namespace Kodbazis\Generated\Route\Embeddable;

use Kodbazis\Generated\Embeddable\Save\SaveController;
use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Repository\Embeddable\SqlLister;
use Kodbazis\Generated\Repository\Embeddable\SqlSaver;
use Kodbazis\Generated\Route\RouterFn;
use Kodbazis\Generated\Slugifier\Slugifier;
use Kodbazis\Generated\ValidationError;
use Kodbazis\Generated\Repository\Auth\JwtTokenVerifier;
use Kodbazis\Generated\Route\Auth\AuthHeaderParser;
use Kodbazis\Generated\Request;
use mysqli;

class EmbeddableSaver implements RouterFn
{
    public function getRoute(Request $request): string
    {
       

        return json_encode((new SaveController(
            new SqlSaver($request->connection),
            new SqlLister($request->connection),
            new ValidationError(),
            new OperationError(),
            new Slugifier())
        )
            ->save($request->body ?? []), JSON_UNESCAPED_UNICODE);
    }
}
  