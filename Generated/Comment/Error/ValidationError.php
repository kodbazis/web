<?php

namespace Kodbazis\Generated\Comment\Error;

use Throwable;

interface ValidationError extends Throwable
{
    public function addErrors(array $fields);
}
  