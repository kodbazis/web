<?php

namespace Kodbazis\Generated\Feedback\Error;

use Throwable;

interface OperationError extends Throwable
{
    public function addField(array $field);
}
  