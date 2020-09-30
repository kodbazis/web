<?php

namespace Kodbazis\Generated\Embeddable\Error;

use Throwable;

interface OperationError extends Throwable
{
    public function addField(array $field);
}
  