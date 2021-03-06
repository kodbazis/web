<?php

namespace Kodbazis\Generated\Post\Save;

use JsonSerializable;

class NewPost implements JsonSerializable
{
    private $title;
private $slug;
private $imgUrl;
private $createdAt;
private $publishedAt;
private $description;
private $content;
private $imgAltTag;
private $isActive;


    
public function __construct($title, $slug, $imgUrl, $createdAt, $publishedAt, $description, $content, $imgAltTag, $isActive)
{
        $this->title = $title;
$this->slug = $slug;
$this->imgUrl = $imgUrl;
$this->createdAt = $createdAt;
$this->publishedAt = $publishedAt;
$this->description = $description;
$this->content = $content;
$this->imgAltTag = $imgAltTag;
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
    public function getCreatedAt(): ?int
    {
        return $this->createdAt;
    }
    public function getPublishedAt(): ?int
    {
        return $this->publishedAt;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function getContent(): ?string
    {
        return $this->content;
    }
    public function getImgAltTag(): ?string
    {
        return $this->imgAltTag;
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
 'createdAt' => $this->createdAt,
 'publishedAt' => $this->publishedAt,
 'description' => $this->description,
 'content' => $this->content,
 'imgAltTag' => $this->imgAltTag,
 'isActive' => $this->isActive,

        ];
    }
}
