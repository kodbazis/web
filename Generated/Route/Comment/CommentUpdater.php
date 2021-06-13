<?php

namespace Kodbazis\Generated\Route\Comment;

use Kodbazis\Generated\Comment\Update\UpdateController;
use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Repository\Comment\SqlUpdater;
use Kodbazis\Generated\ValidationError;
use Kodbazis\Generated\Route\RouterFn;
use Kodbazis\Generated\Repository\Auth\JwtTokenVerifier;
use Kodbazis\Generated\Route\Auth\AuthHeaderParser;
use Kodbazis\Generated\Request;
use mysqli;

class CommentUpdater implements RouterFn
{
    public function getRoute(Request $request): string
    {
        
    
        header("Content-Type: application/json");
        return json_encode((new UpdateController(
            new SqlUpdater($request->connection),
            new OperationError(),
            new ValidationError()
        ))
            ->update($request->body ?? [], $request->vars['id']), JSON_UNESCAPED_UNICODE);
    }
}

  