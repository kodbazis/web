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
private $rating;
private $createdAt;


    
public function __construct($id, $content, $author, $position, $courseId, $rating, $createdAt)
{
        $this->id = $id;
$this->content = $content;
$this->author = $author;
$this->position = $position;
$this->courseId = $courseId;
$this->rating = $rating;
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
            'id' => $this->id,
 'content' => $this->content,
 'author' => $this->author,
 'position' => $this->position,
 'courseId' => $this->courseId,
 'rating' => $this->rating,
 'createdAt' => $this->createdAt,

        ];
    }
}
