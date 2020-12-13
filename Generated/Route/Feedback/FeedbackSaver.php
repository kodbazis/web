<?php

namespace Kodbazis\Generated\Route\Feedback;

use Kodbazis\Generated\Feedback\Save\SaveController;
use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Repository\Feedback\SqlLister;
use Kodbazis\Generated\Repository\Feedback\SqlSaver;
use Kodbazis\Generated\Route\RouterFn;
use Kodbazis\Generated\Slugifier\Slugifier;
use Kodbazis\Generated\ValidationError;
use Kodbazis\Generated\Repository\Auth\JwtTokenVerifier;
use Kodbazis\Generated\Route\Auth\AuthHeaderParser;
use Kodbazis\Generated\Request;
use mysqli;

class FeedbackSaver implements RouterFn
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
  