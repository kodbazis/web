<?php

    namespace Kodbazis\Generated\Post\Patch;

    use Exception;
    use Kodbazis\Generated\Post\Error\Error;
    use Kodbazis\Generated\Post\Error\OperationError;
    use Kodbazis\Generated\Post\Error\ValidationError;
    use Kodbazis\Generated\Post\Post;
      
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
    
        public function patch(array $entity, string $id): Post
        {
            try {
                @$toPatch = new PatchedPost($entity['title'] ?? null, $entity['slug'] ?? null, $entity['imgUrl'] ?? null, $entity['publishedAt'] ?? null, $entity['description'] ?? null, $entity['content'] ?? null, $entity['imgAltTag'] ?? null, (bool)$entity['isActive'] ?? null);
                return $this->patcher->patch($id, $toPatch);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    }

  