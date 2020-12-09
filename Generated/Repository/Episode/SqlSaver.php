<?php

namespace Kodbazis\Generated\Repository\Episode;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Episode\Save\NewEpisode;
use Kodbazis\Generated\Episode\Save\Saver;
use Kodbazis\Generated\Episode\Episode;
use mysqli;

class SqlSaver implements Saver
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function Save(NewEpisode $new): Episode
    {
        try {
            $statement = $this->connection->prepare(
                "INSERT INTO `episodes` (
                `id`, `title`, `slug`, `courseId`, `imgUrl`, `description`, `content`, `createdAt`, `position`
                ) 
                VALUES (NULL, ?,?,?,?,?,?,?,?);"
            );
    
            $title = $new->getTitle();
        $slug = $new->getSlug();
        $courseId = $new->getCourseId();
        $imgUrl = $new->getImgUrl();
        $description = $new->getDescription();
        $content = $new->getContent();
        $createdAt = $new->getCreatedAt();
        $position = $new->getPosition();
        
    
            $statement->bind_param(
                "ssisssii",
                 $title, $slug, $courseId, $imgUrl, $description, $content, $createdAt, $position        
             );
            $statement->execute();
    
            return new Episode((string)$statement->insert_id, $new->getTitle(),$new->getSlug(),$new->getCourseId(),$new->getImgUrl(),$new->getDescription(),$new->getContent(),$new->getCreatedAt(),$new->getPosition());
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

