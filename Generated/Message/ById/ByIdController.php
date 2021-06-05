<?php
    namespace Kodbazis\Generated\Message\ById;
    
    use Exception;
    use Kodbazis\Generated\Message\Error\Error;
    use Kodbazis\Generated\Message\Error\OperationError;
    use Kodbazis\Generated\Message\Message;

    
    class ByIdController
    {
        /**
         * @var ById
         */
        private $byId;
    
        /**
         * @var OperationError
         */
        private $operationError;
    
        public function __construct(ById $byId, OperationError $operationError)
        {
            $this->byId = $byId;
            $this->operationError = $operationError;
        }
    
        public function byId(string $id): Message
        {
            try {
                return $this->byId->byId($id);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    }

  