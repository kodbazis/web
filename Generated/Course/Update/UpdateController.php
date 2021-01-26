<?php

    namespace Kodbazis\Generated\Course\Update;

    use Exception;
    use Kodbazis\Generated\Course\Error\Error;
    use Kodbazis\Generated\Course\Error\OperationError;
    use Kodbazis\Generated\Course\Error\ValidationError;
    use Kodbazis\Generated\Course\Update\Updater;
    use Kodbazis\Generated\Course\Course;
    
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
    
        public function update(array $entity, string $id): Course
        {    
            try {
                $toUpdate = new UpdatedCourse($entity['title'] ?? '', $entity['invoiceTitle'] ?? '', $entity['content'] ?? '', $entity['slug'] ?? '', $entity['imgUrl'] ?? '', $entity['videoId'] ?? '', $entity['description'] ?? '', $entity['isActive'] ?? false, $entity['price'] ?? 0, $entity['discount'] ?? 0);
               
                return $this->updater->update($id, $toUpdate);
            } catch (Exception $err) {
                $this->operationError->addField(Error::getOperationError());
                throw $this->operationError;
            }
        }
    
    }

  