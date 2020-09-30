<?php

    namespace Kodbazis\Generated\Embeddable\Update;

    use Exception;
    use Kodbazis\Generated\Embeddable\Error\Error;
    use Kodbazis\Generated\Embeddable\Error\OperationError;
    use Kodbazis\Generated\Embeddable\Error\ValidationError;
    use Kodbazis\Generated\Embeddable\Update\Updater;
    use Kodbazis\Generated\Embeddable\Embeddable;
    
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
    
        public function update(array $entity, string $id): Embeddable
        {    
            try {
                $toUpdate = new UpdatedEmbeddable($entity['name'] ?? '', $entity['raw'] ?? '', $entity['type'] ?? '');
               
                return $this->updater->update($id, $toUpdate);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    
    }

  