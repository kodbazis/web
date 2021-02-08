<?php

namespace Kodbazis\Generated\Episode\Patch;

use JsonSerializable;

class PatchedEpisode implements JsonSerializable
{
    private $title;
private $slug;
private $courseId;
private $imgUrl;
private $description;
private $shortDescription;
private $content;
private $position;
private $isActive;
private $isPreview;


    
public function __construct($title, $slug, $courseId, $imgUrl, $description, $shortDescription, $content, $position, $isActive, $isPreview)
{
        $this->title = $title;
$this->slug = $slug;
$this->courseId = $courseId;
$this->imgUrl = $imgUrl;
$this->description = $description;
$this->shortDescription = $shortDescription;
$this->content = $content;
$this->position = $position;
$this->isActive = $isActive;
$this->isPreview = $isPreview;

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
            'title' => $this->title,
 'slug' => $this->slug,
 'courseId' => $this->courseId,
 'imgUrl' => $this->imgUrl,
 'description' => $this->description,
 'shortDescription' => $this->shortDescription,
 'content' => $this->content,
 'position' => $this->position,
 'isActive' => $this->isActive,
 'isPreview' => $this->isPreview,

        ];
    }
}
