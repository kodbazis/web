<?php

namespace Kodbazis\Generated;

use Exception;
use JsonSerializable;
use Throwable;

class ValidationError extends Exception implements JsonSerializable, 
\Kodbazis\Generated\Post\Error\ValidationError, \Kodbazis\Generated\Course\Error\ValidationError, \Kodbazis\Generated\Message\Error\ValidationError, \Kodbazis\Generated\Episode\Error\ValidationError, \Kodbazis\Generated\Embeddable\Error\ValidationError, \Kodbazis\Generated\Feedback\Error\ValidationError, \Kodbazis\Generated\Quote\Error\ValidationError, \Kodbazis\Generated\Spec\Error\ValidationError, \Kodbazis\Generated\Subscriber\Error\ValidationError, \Kodbazis\Generated\SubscriberCourse\Error\ValidationError, \Kodbazis\Generated\Coupon\Error\ValidationError
{
    private $fields = [];

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct();
        $this->message = [];
    }

    public function addErrors(array $fields)
    {
        $this->fields = $fields;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function jsonSerialize()
    {
        return [
            "error" => [
                'errors' => $this->fields,
                'code' => 400,
                'message' => "Validation error",
            ],
        ];
    }
}
