<?php

    namespace Kodbazis\Generated\Comment\Patch;

    use Exception;
    use Kodbazis\Generated\Comment\Error\Error;
    use Kodbazis\Generated\Comment\Error\OperationError;
    use Kodbazis\Generated\Comment\Error\ValidationError;
    use Kodbazis\Generated\Comment\Comment;
      
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
    
        public function patch(array $entity, string $id): Comment
        {
            try {
                @$toPatch = new PatchedComment();
                return $this->patcher->patch($id, $toPatch);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    }

  