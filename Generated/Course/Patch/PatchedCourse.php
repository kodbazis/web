<?php

namespace Kodbazis\Generated\Course\Patch;

use JsonSerializable;

class PatchedCourse implements JsonSerializable
{
    private $title;
private $slug;
private $imgUrl;
private $videoId;
private $description;
private $isActive;
private $price;


    
public function __construct($title, $slug, $imgUrl, $videoId, $description, $isActive, $price)
{
        $this->title = $title;
$this->slug = $slug;
$this->imgUrl = $imgUrl;
$this->videoId = $videoId;
$this->description = $description;
$this->isActive = $isActive;
$this->price = $price;

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
    public function getVideoId(): ?string
    {
        return $this->videoId;
    }
    public function getDescription(): ?string
    {
        return $this->description;
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
            'title' => $this->title,
 'slug' => $this->slug,
 'imgUrl' => $this->imgUrl,
 'videoId' => $this->videoId,
 'description' => $this->description,
 'isActive' => $this->isActive,
 'price' => $this->price,

        ];
    }
}
