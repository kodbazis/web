<?php

namespace Kodbazis\Generated\Course;

use JsonSerializable;

class Course implements JsonSerializable
{
    private $id;
private $title;
private $content;
private $slug;
private $imgUrl;
private $videoId;
private $description;
private $createdAt;
private $isActive;
private $price;


    
public function __construct($id, $title, $content, $slug, $imgUrl, $videoId, $description, $createdAt, $isActive, $price)
{
        $this->id = $id;
$this->title = $title;
$this->content = $content;
$this->slug = $slug;
$this->imgUrl = $imgUrl;
$this->videoId = $videoId;
$this->description = $description;
$this->createdAt = $createdAt;
$this->isActive = $isActive;
$this->price = $price;

}
    
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function getContent(): ?string
    {
        return $this->content;
    }
    public function getSlug(): ?string
    {
        return $this->slug;
    }
    public function getImgUrl(): ?string
    {
        return $this->imgUrl;
    }
    public function getVideoId(): ?string
    {
        return $this->videoId;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function getCreatedAt(): ?int
    {
        return $this->createdAt;
    }
    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }
    public function getPrice(): ?int
    {
        return $this->price;
    }
    
    
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
 'title' => $this->title,
 'content' => $this->content,
 'slug' => $this->slug,
 'imgUrl' => $this->imgUrl,
 'videoId' => $this->videoId,
 'description' => $this->description,
 'createdAt' => $this->createdAt,
 'isActive' => $this->isActive,
 'price' => $this->price,

        ];
    }
}
