<?php

namespace Kodbazis\Generated\Quote\Error;

use Throwable;

interface ValidationError extends Throwable
{
    public function addErrors(array $fields);
}
  