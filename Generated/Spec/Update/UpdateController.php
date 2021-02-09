<?php

    namespace Kodbazis\Generated\Spec\Update;

    use Exception;
    use Kodbazis\Generated\Spec\Error\Error;
    use Kodbazis\Generated\Spec\Error\OperationError;
    use Kodbazis\Generated\Spec\Error\ValidationError;
    use Kodbazis\Generated\Spec\Update\Updater;
    use Kodbazis\Generated\Spec\Spec;
    
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
    
        public function update(array $entity, string $id): Spec
        {    
            try {
                $toUpdate = new UpdatedSpec($entity['content'] ?? '', $entity['position'] ?? 0, $entity['courseId'] ?? 0);
               
                return $this->updater->update($id, $toUpdate);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    
    }

  