<?php

namespace Kodbazis\Generated\Message\Error;

use Throwable;

interface ValidationError extends Throwable
{
    public function addErrors(array $fields);
}
  