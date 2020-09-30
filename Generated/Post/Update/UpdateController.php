<?php

    namespace Kodbazis\Generated\Post\Update;

    use Exception;
    use Kodbazis\Generated\Post\Error\Error;
    use Kodbazis\Generated\Post\Error\OperationError;
    use Kodbazis\Generated\Post\Error\ValidationError;
    use Kodbazis\Generated\Post\Update\Updater;
    use Kodbazis\Generated\Post\Post;
    
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
    
        public function update(array $entity, string $id): Post
        {    
            try {
                $toUpdate = new UpdatedPost($entity['title'] ?? '', $entity['slug'] ?? '', $entity['imgUrl'] ?? '', $entity['publishedAt'] ?? 0, $entity['description'] ?? '', $entity['content'] ?? '', $entity['imgAltTag'] ?? '', $entity['isActive'] ?? false);
               
                return $this->updater->update($id, $toUpdate);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    
    }

  