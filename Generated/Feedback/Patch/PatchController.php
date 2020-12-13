<?php

    namespace Kodbazis\Generated\Feedback\Patch;

    use Exception;
    use Kodbazis\Generated\Feedback\Error\Error;
    use Kodbazis\Generated\Feedback\Error\OperationError;
    use Kodbazis\Generated\Feedback\Error\ValidationError;
    use Kodbazis\Generated\Feedback\Feedback;
      
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
    
        public function patch(array $entity, string $id): Feedback
        {
            try {
                @$toPatch = new PatchedFeedback($entity['episodeId'] ?? null);
                return $this->patcher->patch($id, $toPatch);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    }

  