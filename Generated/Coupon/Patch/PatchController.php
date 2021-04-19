<?php

    namespace Kodbazis\Generated\Coupon\Patch;

    use Exception;
    use Kodbazis\Generated\Coupon\Error\Error;
    use Kodbazis\Generated\Coupon\Error\OperationError;
    use Kodbazis\Generated\Coupon\Error\ValidationError;
    use Kodbazis\Generated\Coupon\Coupon;
      
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
    
        public function patch(array $entity, string $id): Coupon
        {
            try {
                @$toPatch = new PatchedCoupon($entity['subscriberId'] ?? null, (bool)$entity['isRedeemed'] ?? null);
                return $this->patcher->patch($id, $toPatch);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    }

  