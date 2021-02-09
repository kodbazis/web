<?php

    namespace Kodbazis\Generated\Quote\Update;

    use Exception;
    use Kodbazis\Generated\Quote\Error\Error;
    use Kodbazis\Generated\Quote\Error\OperationError;
    use Kodbazis\Generated\Quote\Error\ValidationError;
    use Kodbazis\Generated\Quote\Update\Updater;
    use Kodbazis\Generated\Quote\Quote;
    
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
    
        public function update(array $entity, string $id): Quote
        {    
            try {
                $toUpdate = new UpdatedQuote($entity['position'] ?? 0, $entity['courseId'] ?? 0);
               
                return $this->updater->update($id, $toUpdate);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    
    }

  