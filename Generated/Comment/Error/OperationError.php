<?php

namespace Kodbazis\Generated\Comment\Error;

use Throwable;

interface OperationError extends Throwable
{
    public function addField(array $field);
}
  