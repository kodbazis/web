<?php

namespace Kodbazis\Generated\Subscriber\Error;

use Throwable;

interface OperationError extends Throwable
{
    public function addField(array $field);
}
  