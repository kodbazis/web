<?php
    namespace Kodbazis\Generated\Coupon\ById;
    
    use Exception;
    use Kodbazis\Generated\Coupon\Error\Error;
    use Kodbazis\Generated\Coupon\Error\OperationError;
    use Kodbazis\Generated\Coupon\Coupon;

    
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
    
        public function byId(string $id): Coupon
        {
            try {
                return $this->byId->byId($id);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    }

  