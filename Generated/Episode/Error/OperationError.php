<?php

namespace Kodbazis\Generated\Episode\Error;

use Throwable;

interface OperationError extends Throwable
{
    public function addField(array $field);
}
  