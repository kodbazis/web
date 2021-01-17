<?php

namespace Kodbazis\Generated\SubscriberCourse\Error;

use Throwable;

interface OperationError extends Throwable
{
    public function addField(array $field);
}
  