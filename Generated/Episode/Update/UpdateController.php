<?php

    namespace Kodbazis\Generated\Episode\Update;

    use Exception;
    use Kodbazis\Generated\Episode\Error\Error;
    use Kodbazis\Generated\Episode\Error\OperationError;
    use Kodbazis\Generated\Episode\Error\ValidationError;
    use Kodbazis\Generated\Episode\Update\Updater;
    use Kodbazis\Generated\Episode\Episode;
    
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
    
        public function update(array $entity, string $id): Episode
        {    
            try {
                $toUpdate = new UpdatedEpisode($entity['title'] ?? '', $entity['slug'] ?? '', $entity['courseId'] ?? 0, $entity['imgUrl'] ?? '', $entity['description'] ?? '', $entity['content'] ?? '', $entity['position'] ?? 0, $entity['isActive'] ?? false, $entity['isPreview'] ?? false);
               
                return $this->updater->update($id, $toUpdate);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    
    }

  