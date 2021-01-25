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
                `id`, `title`, `content`, `slug`, `imgUrl`, `videoId`, `description`, `createdAt`, `isActive`, `price`
                ) 
                VALUES (NULL, ?,?,?,?,?,?,?,?,?);"
            );
    
            $title = $new->getTitle();
        $content = $new->getContent();
        $slug = $new->getSlug();
        $imgUrl = $new->getImgUrl();
        $videoId = $new->getVideoId();
        $description = $new->getDescription();
        $createdAt = $new->getCreatedAt();
        $isActive = $new->getIsActive();
        $price = $new->getPrice();
        
    
            $statement->bind_param(
                "ssssssiii",
                 $title, $content, $slug, $imgUrl, $videoId, $description, $createdAt, $isActive, $price        
             );
            $statement->execute();
    
            return new Course((string)$statement->insert_id, $new->getTitle(),$new->getContent(),$new->getSlug(),$new->getImgUrl(),$new->getVideoId(),$new->getDescription(),$new->getCreatedAt(),$new->getIsActive(),$new->getPrice());
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

