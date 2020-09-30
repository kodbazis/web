<?php

namespace Kodbazis\Generated\Post\Error;

use Throwable;

interface OperationError extends Throwable
{
    public function addField(array $field);
}
  