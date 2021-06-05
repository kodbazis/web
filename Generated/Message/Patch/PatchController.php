<?php

    namespace Kodbazis\Generated\Message\Patch;

    use Exception;
    use Kodbazis\Generated\Message\Error\Error;
    use Kodbazis\Generated\Message\Error\OperationError;
    use Kodbazis\Generated\Message\Error\ValidationError;
    use Kodbazis\Generated\Message\Message;
      
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
    
        public function patch(array $entity, string $id): Message
        {
            try {
                @$toPatch = new PatchedMessage($entity['status'] ?? null, $entity['numberOfAttempts'] ?? null, $entity['sentAt'] ?? null);
                return $this->patcher->patch($id, $toPatch);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    }

  