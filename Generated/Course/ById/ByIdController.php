<?php
    namespace Kodbazis\Generated\Course\ById;
    
    use Exception;
    use Kodbazis\Generated\Course\Error\Error;
    use Kodbazis\Generated\Course\Error\OperationError;
    use Kodbazis\Generated\Course\Course;

    
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
    
        public function byId(string $id): Course
        {
            try {
                return $this->byId->byId($id);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    }

  