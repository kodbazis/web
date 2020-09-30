<?php

namespace Kodbazis\Generated\Course\Error;

use Throwable;

interface ValidationError extends Throwable
{
    public function addErrors(array $fields);
}
  