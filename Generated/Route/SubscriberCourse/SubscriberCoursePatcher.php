<?php

namespace Kodbazis\Generated\Route\SubscriberCourse;

use Kodbazis\Generated\SubscriberCourse\Patch\PatchController;
use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Repository\SubscriberCourse\SqlPatcher;
use Kodbazis\Generated\ValidationError;
use Kodbazis\Generated\Route\RouterFn;
use Kodbazis\Generated\Repository\Auth\JwtTokenVerifier;
use Kodbazis\Generated\Route\Auth\AuthHeaderParser;
use Kodbazis\Generated\Request;
use mysqli;

class SubscriberCoursePatcher implements RouterFn
{
    public function getRoute(Request $request): string
    {
       

        header("Content-Type: application/json");
        return json_encode((new PatchController(
            new SqlPatcher($request->connection),
            new OperationError(),
            new ValidationError()
        ))
            ->patch($request->body ?? [], $request->vars['id']), JSON_UNESCAPED_UNICODE);
    }
}

  