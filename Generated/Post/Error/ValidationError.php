<?php

namespace Kodbazis\Generated\Post\Error;

use Throwable;

interface ValidationError extends Throwable
{
    public function addErrors(array $fields);
}
  