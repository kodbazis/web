<?php

    namespace Kodbazis\Generated\Quote\Patch;

    use Exception;
    use Kodbazis\Generated\Quote\Error\Error;
    use Kodbazis\Generated\Quote\Error\OperationError;
    use Kodbazis\Generated\Quote\Error\ValidationError;
    use Kodbazis\Generated\Quote\Quote;
      
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
    
        public function patch(array $entity, string $id): Quote
        {
            try {
                @$toPatch = new PatchedQuote($entity['position'] ?? null, $entity['courseId'] ?? null);
                return $this->patcher->patch($id, $toPatch);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    }

  