<?php

    namespace Kodbazis\Generated\SubscriberCourse\Patch;

    use Exception;
    use Kodbazis\Generated\SubscriberCourse\Error\Error;
    use Kodbazis\Generated\SubscriberCourse\Error\OperationError;
    use Kodbazis\Generated\SubscriberCourse\Error\ValidationError;
    use Kodbazis\Generated\SubscriberCourse\SubscriberCourse;
      
    class PatchController
    {
        /**
         * @var Patcher
         */
        private $patcher;
    
        /**
         * @var OperationError
         */
        private $operationError;
    
        /**
         * @var ValidationError
         */
        private $requiredError;
    
        public function __construct(Patcher $updater, OperationError $operationError, ValidationError $requiredError)
        {
            $this->patcher = $updater;
            $this->operationError = $operationError;
            $this->requiredError = $requiredError;
        }
    
        public function patch(array $entity, string $id): SubscriberCourse
        {
            try {
                @$toPatch = new PatchedSubscriberCourse($entity['name'] ?? null, $entity['taxNumber'] ?? null, $entity['zip'] ?? null, $entity['city'] ?? null, $entity['address'] ?? null, $entity['purchaseType'] ?? null, $entity['orderRef'] ?? null, (bool)$entity['isPayed'] ?? null, (bool)$entity['isVerified'] ?? null, (bool)$entity['isInvoiceSent'] ?? null);
                return $this->patcher->patch($id, $toPatch);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    }

  