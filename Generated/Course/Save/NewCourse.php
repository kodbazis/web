<?php

namespace Kodbazis\Generated\Course\Save;

use JsonSerializable;

class NewCourse implements JsonSerializable
{
    private $title;
private $slug;
private $imgUrl;
private $description;
private $videoUrl;
private $createdAt;
private $isActive;


    
public function __construct($title, $slug, $imgUrl, $description, $videoUrl, $createdAt, $isActive)
{
        $this->title = $title;
$this->slug = $slug;
$this->imgUrl = $imgUrl;
$this->description = $description;
$this->videoUrl = $videoUrl;
$this->createdAt = $createdAt;
$this->isActive = $isActive;

}
    
    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function getSlug(): ?string
    {
        return $this->slug;
    }
    public function getImgUrl(): ?string
    {
        return $this->imgUrl;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function getVideoUrl(): ?string
    {
        return $this->videoUrl;
    }
    public function getCreatedAt(): ?int
    {
        return $this->createdAt;
    }
    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }
    
    
    public function jsonSerialize()
    {
        return [
            'title' => $this->title,
 'slug' => $this->slug,
 'imgUrl' => $this->imgUrl,
 'description' => $this->description,
 'videoUrl' => $this->videoUrl,
 'createdAt' => $this->createdAt,
 'isActive' => $this->isActive,

        ];
    }
}
