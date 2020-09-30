<?php

namespace Kodbazis\Generated\Course\Error;

use Throwable;

interface OperationError extends Throwable
{
    public function addField(array $field);
}
  