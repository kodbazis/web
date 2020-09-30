<?php
    namespace Kodbazis\Generated\Embeddable\ById;
    
    use Exception;
    use Kodbazis\Generated\Embeddable\Error\Error;
    use Kodbazis\Generated\Embeddable\Error\OperationError;
    use Kodbazis\Generated\Embeddable\Embeddable;

    
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
    
        public function byId(string $id): Embeddable
        {
            try {
                return $this->byId->byId($id);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    }

  