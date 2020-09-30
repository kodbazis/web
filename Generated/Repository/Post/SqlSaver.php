<?php

namespace Kodbazis\Generated\Repository\Post;

use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Post\Save\NewPost;
use Kodbazis\Generated\Post\Save\Saver;
use Kodbazis\Generated\Post\Post;
use mysqli;

class SqlSaver implements Saver
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function Save(NewPost $new): Post
    {
        try {
            $statement = $this->connection->prepare(
                "INSERT INTO `posts` (
                `id`, `title`, `slug`, `imgUrl`, `createdAt`, `publishedAt`, `description`, `content`, `imgAltTag`, `isActive`
                ) 
                VALUES (NULL, ?,?,?,?,?,?,?,?,?);"
            );
    
            $title = $new->getTitle();
        $slug = $new->getSlug();
        $imgUrl = $new->getImgUrl();
        $createdAt = $new->getCreatedAt();
        $publishedAt = $new->getPublishedAt();
        $description = $new->getDescription();
        $content = $new->getContent();
        $imgAltTag = $new->getImgAltTag();
        $isActive = $new->getIsActive();
        
    
            $statement->bind_param(
                "sssiisssi",
                 $title, $slug, $imgUrl, $createdAt, $publishedAt, $description, $content, $imgAltTag, $isActive        
             );
            $statement->execute();
    
            return new Post((string)$statement->insert_id, $new->getTitle(),$new->getSlug(),$new->getImgUrl(),$new->getCreatedAt(),$new->getPublishedAt(),$new->getDescription(),$new->getContent(),$new->getImgAltTag(),$new->getIsActive());
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

