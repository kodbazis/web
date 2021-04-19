<?php

namespace Kodbazis\Generated\Coupon\Error;

use Throwable;

interface ValidationError extends Throwable
{
    public function addErrors(array $fields);
}
  