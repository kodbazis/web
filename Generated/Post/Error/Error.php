<?php

namespace Kodbazis\Generated\Post\Error;

use JsonSerializable;

class Error
{
    public static function getOperationError(): array
    {
        return [
            "reason" => "post operation failed",
            "message" => "Operation failed",
            "locationType" => "resource",
            "location" => "post",
        ];
    }

    public static function getValidationError(string $fieldName): array
    {
        return [
            "reason" => "$fieldName is required",
            "message" => "required",
            "locationType" => $fieldName,
            "location" => "post",
        ];
    }

    public static function getNotUniqueError(string $fieldName): array
    {
        return [
            "reason" => "$fieldName must be unique",
            "message" => "unique",
            "locationType" => $fieldName,
            "location" => "post",
        ];
    }

    public static function getTypeError(string $fieldName): array
    {
        return [
            "reason" => "$fieldName type mismatch",
            "message" => "type",
            "locationType" => $fieldName,
            "location" => "post",
        ];
    }

}


  