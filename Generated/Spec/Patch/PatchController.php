<?php

    namespace Kodbazis\Generated\Spec\Patch;

    use Exception;
    use Kodbazis\Generated\Spec\Error\Error;
    use Kodbazis\Generated\Spec\Error\OperationError;
    use Kodbazis\Generated\Spec\Error\ValidationError;
    use Kodbazis\Generated\Spec\Spec;
      
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
    
        public function patch(array $entity, string $id): Spec
        {
            try {
                @$toPatch = new PatchedSpec($entity['content'] ?? null, $entity['position'] ?? null, $entity['courseId'] ?? null);
                return $this->patcher->patch($id, $toPatch);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    }

  