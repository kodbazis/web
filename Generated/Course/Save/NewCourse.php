<?php

namespace Kodbazis\Generated\Course\Save;

use JsonSerializable;

class NewCourse implements JsonSerializable
{
    private $title;
private $slug;
private $imgUrl;
private $description;
private $createdAt;
private $isActive;
private $price;


    
public function __construct($title, $slug, $imgUrl, $description, $createdAt, $isActive, $price)
{
        $this->title = $title;
$this->slug = $slug;
$this->imgUrl = $imgUrl;
$this->description = $description;
$this->createdAt = $createdAt;
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
            'title' => $this->title,
 'slug' => $this->slug,
 'imgUrl' => $this->imgUrl,
 'description' => $this->description,
 'createdAt' => $this->createdAt,
 'isActive' => $this->isActive,
 'price' => $this->price,

        ];
    }
}
