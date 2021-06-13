<?php

    namespace Kodbazis\Generated\Comment\Update;

    use Exception;
    use Kodbazis\Generated\Comment\Error\Error;
    use Kodbazis\Generated\Comment\Error\OperationError;
    use Kodbazis\Generated\Comment\Error\ValidationError;
    use Kodbazis\Generated\Comment\Update\Updater;
    use Kodbazis\Generated\Comment\Comment;
    
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
    
        public function update(array $entity, string $id): Comment
        {    
            try {
                $toUpdate = new UpdatedComment();
               
                return $this->updater->update($id, $toUpdate);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    
    }

  