<?php

    namespace Kodbazis\Generated\Course\Patch;

    use Exception;
    use Kodbazis\Generated\Course\Error\Error;
    use Kodbazis\Generated\Course\Error\OperationError;
    use Kodbazis\Generated\Course\Error\ValidationError;
    use Kodbazis\Generated\Course\Course;
      
    class PatchController
    {
        /**
         * @var Patcher
         */
        private $patcher;
    
        /**
         * @var OperationError
         */
        private $operationError;
    
        /**
         * @var ValidationError
         */
        private $requiredError;
    
        public function __construct(Patcher $updater, OperationError $operationError, ValidationError $requiredError)
        {
            $this->patcher = $updater;
            $this->operationError = $operationError;
            $this->requiredError = $requiredError;
        }
    
        public function patch(array $entity, string $id): Course
        {
            try {
                @$toPatch = new PatchedCourse($entity['title'] ?? null, $entity['slug'] ?? null, $entity['imgUrl'] ?? null, $entity['videoId'] ?? null, $entity['description'] ?? null, (bool)$entity['isActive'] ?? null, $entity['price'] ?? null);
                return $this->patcher->patch($id, $toPatch);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    }

  