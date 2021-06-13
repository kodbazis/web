<?php

  namespace Kodbazis\Generated\Comment\Save;

  use Exception;
  use Kodbazis\Generated\Comment\Error\Error;
  use Kodbazis\Generated\Comment\Error\OperationError;
  use Kodbazis\Generated\Comment\Error\ValidationError;
  use Kodbazis\Generated\Comment\Listing\Lister;
  use Kodbazis\Generated\Comment\Comment;
  use Kodbazis\Generated\Listing\Clause;
  use Kodbazis\Generated\Listing\Filter;
  use Kodbazis\Generated\Listing\OrderBy;
  use Kodbazis\Generated\Listing\Query;

  class SaveController
{
    private $saver;

    private $lister;

    private $validationError;

    private $operationError;

    public function __construct(Saver $saver, Lister $lister, ValidationError $validationError, OperationError $operationError, Slugifier $slugifier)
    {
        $this->saver = $saver;
        $this->validationError = $validationError;
        $this->operationError = $operationError;
        $this->slugifier = $slugifier;
        $this->lister = $lister;
    }

    public function save(array $entity): Comment
    {
        $missing = array_map(function ($fieldName) {
            return Error::getValidationError($fieldName);
        }, array_filter(['content', 'embeddableId', 'key'], function ($fieldName) use ($entity) {
            return empty($entity[$fieldName]);
        }));

        $entity['createdAt'] = (new \DateTime())->getTimestamp();


        $notUnique = array_map(function ($fieldName) {
            return Error::getNotUniqueError($fieldName);
        }, array_filter([], function ($fieldName) use ($entity) {
            return !empty($this->lister
                ->list(new Query(1, 0, new Clause('eq', $fieldName, $entity[$fieldName] ?? ''), new OrderBy('', '')))
                ->getEntities());
        }));

        //  $type = array_map(function ($keyValue) {
        //     return Error::getTypeError($keyValue[0]);
        // }, array_filter($this->toKeyValue($entity), function ($keyValue) {
        //     return !call_user_func($this->getTypeValidatorFn($keyValue[0]), $keyValue[1]);
        // }));

        $errors = array_merge($notUnique, $missing);

        if (count($errors) > 0) {
            $this->validationError->addErrors($errors);
            throw $this->validationError;
        }

        try {
          $toSave = new NewComment((string)($entity['content']), (int)($entity['embeddableId']), (string)($entity['key']), (int)($entity['createdAt'] ?? 0));
              return $this->saver->Save($toSave);
        } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
        }
    }

    private function toKeyValue(array $array)
    {
        return array_map(function ($key, $value) {
            return [$key, $value];
        }, array_keys($array), $array);
    }

    private function getTypeValidatorFn($key)
    {
        $validators = [
            'content' => [$this, 'isString'],
            'embeddableId' => [$this, 'isInt'],
            'key' => [$this, 'isString'],
            'createdAt' => [$this, 'isInt']

        ];
        if (!array_key_exists($key, $validators)) {
            return function ($val) {
                return true;
            };
        }
        return $validators[$key];
    }

    private function isString($val): bool
    {
        return is_string($val);
    }

    private function isInt($val): bool
    {
        return is_int($val);
    }

    private function isBool($val): bool
    {
        return is_bool($val);
    }

    private function isJson($val): bool
    {
        json_decode($val);
        return (json_last_error() == JSON_ERROR_NONE);
    }

  }

