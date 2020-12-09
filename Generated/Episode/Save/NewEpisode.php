<?php

namespace Kodbazis\Generated\Episode\Save;

use JsonSerializable;

class NewEpisode implements JsonSerializable
{
    private $title;
private $slug;
private $courseId;
private $imgUrl;
private $description;
private $content;
private $createdAt;
private $position;


    
public function __construct($title, $slug, $courseId, $imgUrl, $description, $content, $createdAt, $position)
{
        $this->title = $title;
$this->slug = $slug;
$this->courseId = $courseId;
$this->imgUrl = $imgUrl;
$this->description = $description;
$this->content = $content;
$this->createdAt = $createdAt;
$this->position = $position;

}
    
    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function getSlug(): ?string
    {
        return $this->slug;
    }
    public function getCourseId(): ?int
    {
        return $this->courseId;
    }
    public function getImgUrl(): ?string
    {
        return $this->imgUrl;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function getContent(): ?string
    {
        return $this->content;
    }
    public function getCreatedAt(): ?int
    {
        return $this->createdAt;
    }
    public function getPosition(): ?int
    {
        return $this->position;
    }
    
    
    public function jsonSerialize()
    {
        return [
            'title' => $this->title,
 'slug' => $this->slug,
 'courseId' => $this->courseId,
 'imgUrl' => $this->imgUrl,
 'description' => $this->description,
 'content' => $this->content,
 'createdAt' => $this->createdAt,
 'position' => $this->position,

        ];
    }
}
