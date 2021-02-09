<?php

namespace Kodbazis\Generated\Quote;

use JsonSerializable;

class Quote implements JsonSerializable
{
    private $id;
private $content;
private $author;
private $position;
private $courseId;
private $createdAt;


    
public function __construct($id, $content, $author, $position, $courseId, $createdAt)
{
        $this->id = $id;
$this->content = $content;
$this->author = $author;
$this->position = $position;
$this->courseId = $courseId;
$this->createdAt = $createdAt;

}
    
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getContent(): ?string
    {
        return $this->content;
    }
    public function getAuthor(): ?string
    {
        return $this->author;
    }
    public function getPosition(): ?int
    {
        return $this->position;
    }
    public function getCourseId(): ?int
    {
        return $this->courseId;
    }
    public function getCreatedAt(): ?int
    {
        return $this->createdAt;
    }
    
    
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
 'content' => $this->content,
 'author' => $this->author,
 'position' => $this->position,
 'courseId' => $this->courseId,
 'createdAt' => $this->createdAt,

        ];
    }
}
