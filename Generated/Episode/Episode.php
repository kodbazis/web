<?php

namespace Kodbazis\Generated\Episode;

use JsonSerializable;

class Episode implements JsonSerializable
{
    private $id;
private $title;
private $slug;
private $courseId;
private $imgUrl;
private $description;
private $shortDescription;
private $content;
private $createdAt;
private $position;
private $isActive;
private $isPreview;


    
public function __construct($id, $title, $slug, $courseId, $imgUrl, $description, $shortDescription, $content, $createdAt, $position, $isActive, $isPreview)
{
        $this->id = $id;
$this->title = $title;
$this->slug = $slug;
$this->courseId = $courseId;
$this->imgUrl = $imgUrl;
$this->description = $description;
$this->shortDescription = $shortDescription;
$this->content = $content;
$this->createdAt = $createdAt;
$this->position = $position;
$this->isActive = $isActive;
$this->isPreview = $isPreview;

}
    
    public function getId(): ?int
    {
        return $this->id;
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
    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
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
    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }
    public function getIsPreview(): ?bool
    {
        return $this->isPreview;
    }
    
    
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
 'title' => $this->title,
 'slug' => $this->slug,
 'courseId' => $this->courseId,
 'imgUrl' => $this->imgUrl,
 'description' => $this->description,
 'shortDescription' => $this->shortDescription,
 'content' => $this->content,
 'createdAt' => $this->createdAt,
 'position' => $this->position,
 'isActive' => $this->isActive,
 'isPreview' => $this->isPreview,

        ];
    }
}
