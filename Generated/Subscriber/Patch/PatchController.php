<?php

    namespace Kodbazis\Generated\Subscriber\Patch;

    use Exception;
    use Kodbazis\Generated\Subscriber\Error\Error;
    use Kodbazis\Generated\Subscriber\Error\OperationError;
    use Kodbazis\Generated\Subscriber\Error\ValidationError;
    use Kodbazis\Generated\Subscriber\Subscriber;
      
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
    
        public function patch(array $entity, string $id): Subscriber
        {
            try {
                @$toPatch = new PatchedSubscriber($entity['email'] ?? null, $entity['password'] ?? null, (bool)$entity['isVerified'] ?? null, $entity['verificationToken'] ?? null);
                return $this->patcher->patch($id, $toPatch);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    }

  