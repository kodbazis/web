<?php

namespace Kodbazis\Generated\Coupon\Error;

use Throwable;

interface OperationError extends Throwable
{
    public function addField(array $field);
}
  