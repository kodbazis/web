<?php

namespace Kodbazis\Generated\Embeddable\Error;

use Throwable;

interface ValidationError extends Throwable
{
    public function addErrors(array $fields);
}
  