<?php

namespace Kodbazis\Generated\Spec\Error;

use Throwable;

interface ValidationError extends Throwable
{
    public function addErrors(array $fields);
}
  