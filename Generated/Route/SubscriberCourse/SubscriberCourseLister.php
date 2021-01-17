<?php

namespace Kodbazis\Generated\Route\SubscriberCourse;

use Kodbazis\Generated\SubscriberCourse\Listing\ListController;
use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Paging\Pager;
use Kodbazis\Generated\Repository\SubscriberCourse\SqlLister;
use Kodbazis\Generated\Route\Error;
use Kodbazis\Generated\Route\RouterFn;
use Kodbazis\Generated\Repository\Auth\JwtTokenVerifier;
use Kodbazis\Generated\Route\Auth\AuthHeaderParser;
use Kodbazis\Generated\Request;
use mysqli;

class SubscriberCourseLister implements RouterFn
{
    public function getRoute(Request $request): string
    {
        

        $query = $request->query;
        Error::validateQueryParams($query, ['from', 'limit']);

        if (isset($query['filters'])) {
            $query['filters'] = (array)json_decode(($query['filters'] ?? ''), true);
        }

        if (isset($query['filters'])) {
            $query['orderBy'] = (array)json_decode(($query['orderBy'] ?? ''), true);
        }

        header("Content-Type: application/json");
        return json_encode((new ListController(
            new OperationError(),
            new SqlLister($request->connection),
            new Pager())
        )->list($query), JSON_UNESCAPED_UNICODE);
    }
}
  