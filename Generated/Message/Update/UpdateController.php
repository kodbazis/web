<?php

    namespace Kodbazis\Generated\Message\Update;

    use Exception;
    use Kodbazis\Generated\Message\Error\Error;
    use Kodbazis\Generated\Message\Error\OperationError;
    use Kodbazis\Generated\Message\Error\ValidationError;
    use Kodbazis\Generated\Message\Update\Updater;
    use Kodbazis\Generated\Message\Message;
    
    class UpdateController
    {
        /**
         * @var Updater
         */
        private $updater;
    
        /**
         * @var OperationError
         */
        private $operationError;
    
        /**
         * @var ValidationError
         */
        private $requiredError;
    
        public function __construct(Updater $updater, OperationError $operationError, ValidationError $requiredError)
        {
            $this->updater = $updater;
            $this->operationError = $operationError;
            $this->requiredError = $requiredError;
        }
    
        public function update(array $entity, string $id): Message
        {    
            try {
                $toUpdate = new UpdatedMessage($entity['status'] ?? '', $entity['numberOfAttempts'] ?? 0, $entity['sentAt'] ?? 0);
               
                return $this->updater->update($id, $toUpdate);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    
    }

  