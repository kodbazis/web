<?php
    namespace Kodbazis\Generated\Quote\ById;
    
    use Exception;
    use Kodbazis\Generated\Quote\Error\Error;
    use Kodbazis\Generated\Quote\Error\OperationError;
    use Kodbazis\Generated\Quote\Quote;

    
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
    
        public function byId(string $id): Quote
        {
            try {
                return $this->byId->byId($id);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    }

  