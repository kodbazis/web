<?php

    namespace Kodbazis\Generated\Feedback\Update;

    use Exception;
    use Kodbazis\Generated\Feedback\Error\Error;
    use Kodbazis\Generated\Feedback\Error\OperationError;
    use Kodbazis\Generated\Feedback\Error\ValidationError;
    use Kodbazis\Generated\Feedback\Update\Updater;
    use Kodbazis\Generated\Feedback\Feedback;
    
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
    
        public function update(array $entity, string $id): Feedback
        {    
            try {
                $toUpdate = new UpdatedFeedback($entity['episodeId'] ?? 0);
               
                return $this->updater->update($id, $toUpdate);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    
    }

  