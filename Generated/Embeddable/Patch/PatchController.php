<?php

    namespace Kodbazis\Generated\Embeddable\Patch;

    use Exception;
    use Kodbazis\Generated\Embeddable\Error\Error;
    use Kodbazis\Generated\Embeddable\Error\OperationError;
    use Kodbazis\Generated\Embeddable\Error\ValidationError;
    use Kodbazis\Generated\Embeddable\Embeddable;
      
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
    
        public function patch(array $entity, string $id): Embeddable
        {
            try {
                @$toPatch = new PatchedEmbeddable($entity['name'] ?? null, $entity['raw'] ?? null, $entity['type'] ?? null);
                return $this->patcher->patch($id, $toPatch);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    }

  