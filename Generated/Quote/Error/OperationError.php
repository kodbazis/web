<?php

namespace Kodbazis\Generated\Quote\Error;

use Throwable;

interface OperationError extends Throwable
{
    public function addField(array $field);
}
  