<?php

namespace Kodbazis\Generated\Repository\Course;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Course\Save\NewCourse;
use Kodbazis\Generated\Course\Save\Saver;
use Kodbazis\Generated\Course\Course;
use mysqli;

class SqlSaver implements Saver
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function Save(NewCourse $new): Course
    {
        try {
            $statement = $this->connection->prepare(
                "INSERT INTO `courses` (
                `id`, `title`, `slug`, `imgUrl`, `description`, `createdAt`, `isActive`
                ) 
                VALUES (NULL, ?,?,?,?,?,?);"
            );
    
            $title = $new->getTitle();
        $slug = $new->getSlug();
        $imgUrl = $new->getImgUrl();
        $description = $new->getDescription();
        $createdAt = $new->getCreatedAt();
        $isActive = $new->getIsActive();
        
    
            $statement->bind_param(
                "ssssii",
                 $title, $slug, $imgUrl, $description, $createdAt, $isActive        
             );
            $statement->execute();
    
            return new Course((string)$statement->insert_id, $new->getTitle(),$new->getSlug(),$new->getImgUrl(),$new->getDescription(),$new->getCreatedAt(),$new->getIsActive());
        } catch (\Error $exception) {
            if ($_SERVER['DEPLOYMENT_ENV'] === 'dev') {
                var_dump($exception);
                exit;
            }
            throw new OperationError("save error");
        } catch (\Exception $exception) {
            if ($_SERVER['DEPLOYMENT_ENV'] === 'dev') {
                var_dump($exception);
                exit;
            }
            throw new OperationError("save error");
        }
    }
}

