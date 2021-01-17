<?php

namespace Kodbazis\Generated\SubscriberCourse\Error;

use Throwable;

interface ValidationError extends Throwable
{
    public function addErrors(array $fields);
}
  