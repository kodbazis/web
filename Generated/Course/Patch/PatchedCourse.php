<?php

namespace Kodbazis\Generated\Course\Patch;

use JsonSerializable;

class PatchedCourse implements JsonSerializable
{
    private $title;
private $slug;
private $imgUrl;
private $description;
private $isActive;


    
public function __construct($title, $slug, $imgUrl, $description, $isActive)
{
        $this->title = $title;
$this->slug = $slug;
$this->imgUrl = $imgUrl;
$this->description = $description;
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
 'isActive' => $this->isActive,

        ];
    }
}
