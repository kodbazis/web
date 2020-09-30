<?php

namespace Kodbazis\Generated\Episode\Error;

use JsonSerializable;

class Error
{
    public static function getOperationError(): array
    {
        return [
            "reason" => "episode operation failed",
            "message" => "Operation failed",
            "locationType" => "resource",
            "location" => "episode",
        ];
    }

    public static function getValidationError(string $fieldName): array
    {
        return [
            "reason" => "$fieldName is required",
            "message" => "required",
            "locationType" => $fieldName,
            "location" => "episode",
        ];
    }

    public static function getNotUniqueError(string $fieldName): array
    {
        return [
            "reason" => "$fieldName must be unique",
            "message" => "unique",
            "locationType" => $fieldName,
            "location" => "episode",
        ];
    }

    public static function getTypeError(string $fieldName): array
    {
        return [
            "reason" => "$fieldName type mismatch",
            "message" => "type",
            "locationType" => $fieldName,
            "location" => "episode",
        ];
    }

}


  