<?php

namespace Kodbazis\Generated\Quote\Save;

use JsonSerializable;

class NewQuote implements JsonSerializable
{
    private $content;
private $author;
private $position;
private $courseId;
private $createdAt;


    
public function __construct($content, $author, $position, $courseId, $createdAt)
{
        $this->content = $content;
$this->author = $author;
$this->position = $position;
$this->courseId = $courseId;
$this->createdAt = $createdAt;

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
            'content' => $this->content,
 'author' => $this->author,
 'position' => $this->position,
 'courseId' => $this->courseId,
 'createdAt' => $this->createdAt,

        ];
    }
}
