<?php
    namespace Kodbazis\Generated\SubscriberCourse\ById;
    
    use Exception;
    use Kodbazis\Generated\SubscriberCourse\Error\Error;
    use Kodbazis\Generated\SubscriberCourse\Error\OperationError;
    use Kodbazis\Generated\SubscriberCourse\SubscriberCourse;

    
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
    
        public function byId(string $id): SubscriberCourse
        {
            try {
                return $this->byId->byId($id);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    }

  