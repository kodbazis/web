<?php

namespace Kodbazis\Generated\Quote\Save;

use JsonSerializable;

class NewQuote implements JsonSerializable
{
    private $content;
private $author;
private $position;
private $courseId;
private $rating;
private $createdAt;


    
public function __construct($content, $author, $position, $courseId, $rating, $createdAt)
{
        $this->content = $content;
$this->author = $author;
$this->position = $position;
$this->courseId = $courseId;
$this->rating = $rating;
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
    public function getRating(): ?int
    {
        return $this->rating;
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
 'rating' => $this->rating,
 'createdAt' => $this->createdAt,

        ];
    }
}
