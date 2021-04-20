<?php

    namespace Kodbazis\Generated\Coupon\Update;

    use Exception;
    use Kodbazis\Generated\Coupon\Error\Error;
    use Kodbazis\Generated\Coupon\Error\OperationError;
    use Kodbazis\Generated\Coupon\Error\ValidationError;
    use Kodbazis\Generated\Coupon\Update\Updater;
    use Kodbazis\Generated\Coupon\Coupon;
    
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
    
        public function update(array $entity, string $id): Coupon
        {    
            try {
                $toUpdate = new UpdatedCoupon($entity['redeemedBy'] ?? 0);
               
                return $this->updater->update($id, $toUpdate);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    
    }

  