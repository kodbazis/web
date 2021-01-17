<?php

    namespace Kodbazis\Generated\SubscriberCourse\Update;

    use Exception;
    use Kodbazis\Generated\SubscriberCourse\Error\Error;
    use Kodbazis\Generated\SubscriberCourse\Error\OperationError;
    use Kodbazis\Generated\SubscriberCourse\Error\ValidationError;
    use Kodbazis\Generated\SubscriberCourse\Update\Updater;
    use Kodbazis\Generated\SubscriberCourse\SubscriberCourse;
    
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
    
        public function update(array $entity, string $id): SubscriberCourse
        {    
            try {
                $toUpdate = new UpdatedSubscriberCourse($entity['name'] ?? '', $entity['taxNumber'] ?? '', $entity['zip'] ?? 0, $entity['city'] ?? '', $entity['address'] ?? '', $entity['purchaseType'] ?? '', $entity['orderRef'] ?? '', $entity['isPayed'] ?? false, $entity['isVerified'] ?? false, $entity['isInvoiceSent'] ?? false);
               
                return $this->updater->update($id, $toUpdate);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    
    }

  