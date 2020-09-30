<?php
    namespace Kodbazis\Generated\Episode\Delete;
    
    use Exception;
    use Kodbazis\Generated\Episode\Error\Error;
    use Kodbazis\Generated\Episode\Error\OperationError;
    
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

  