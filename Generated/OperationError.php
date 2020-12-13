<?php

namespace Kodbazis\Generated;

use Exception;
use JsonSerializable;
use Throwable;

class OperationError extends Exception implements JsonSerializable, 
\Kodbazis\Generated\Post\Error\OperationError, \Kodbazis\Generated\Course\Error\OperationError, \Kodbazis\Generated\Episode\Error\OperationError, \Kodbazis\Generated\Embeddable\Error\OperationError, \Kodbazis\Generated\Feedback\Error\OperationError
{
    private $fields = [];

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct();
        $this->message = [];
    }

    public function addField(array $field)
    {
        $this->fields[] = $field;
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
                'message' => "Operation error",
            ],
        ];
    }
}
