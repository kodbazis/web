<?php

namespace Kodbazis\Generated\Feedback\Error;

use Throwable;

interface ValidationError extends Throwable
{
    public function addErrors(array $fields);
}
  