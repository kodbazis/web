<?php

namespace Kodbazis\Generated\Episode\Error;

use Throwable;

interface ValidationError extends Throwable
{
    public function addErrors(array $fields);
}
  