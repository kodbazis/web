<?php

    namespace Kodbazis\Generated\Episode\Patch;

    use Exception;
    use Kodbazis\Generated\Episode\Error\Error;
    use Kodbazis\Generated\Episode\Error\OperationError;
    use Kodbazis\Generated\Episode\Error\ValidationError;
    use Kodbazis\Generated\Episode\Episode;
      
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
    
        public function patch(array $entity, string $id): Episode
        {
            try {
                @$toPatch = new PatchedEpisode($entity['title'] ?? null, $entity['slug'] ?? null, $entity['courseId'] ?? null, $entity['imgUrl'] ?? null, $entity['videoFileName'] ?? null, $entity['description'] ?? null, $entity['content'] ?? null);
                return $this->patcher->patch($id, $toPatch);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    }

  