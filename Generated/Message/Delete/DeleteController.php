<?php
    namespace Kodbazis\Generated\Message\Delete;
    
    use Exception;
    use Kodbazis\Generated\Message\Error\Error;
    use Kodbazis\Generated\Message\Error\OperationError;
    
    class DeleteController
    {
        private $operationError;
    
        private $deleter;
    
        public function __construct(OperationError $operationError, Deleter $deleter)
        {
            $this->operationError = $operationError;
            $this->deleter = $deleter;
        }
    
        public function delete(string $id)
        {
            try {
                return $this->deleter->delete($id);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    }

  