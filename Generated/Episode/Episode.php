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
private $videoFileName;
private $description;
private $content;
private $createdAt;


    
public function __construct($id, $title, $slug, $courseId, $imgUrl, $videoFileName, $description, $content, $createdAt)
{
        $this->id = $id;
$this->title = $title;
$this->slug = $slug;
$this->courseId = $courseId;
$this->imgUrl = $imgUrl;
$this->videoFileName = $videoFileName;
$this->description = $description;
$this->content = $content;
$this->createdAt = $createdAt;

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
    public function getVideoFileName(): ?string
    {
        return $this->videoFileName;
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
    
    
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
 'title' => $this->title,
 'slug' => $this->slug,
 'courseId' => $this->courseId,
 'imgUrl' => $this->imgUrl,
 'videoFileName' => $this->videoFileName,
 'description' => $this->description,
 'content' => $this->content,
 'createdAt' => $this->createdAt,

        ];
    }
}
