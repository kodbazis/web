<?php

namespace Kodbazis\Generated\Spec\Error;

use Throwable;

interface OperationError extends Throwable
{
    public function addField(array $field);
}
  