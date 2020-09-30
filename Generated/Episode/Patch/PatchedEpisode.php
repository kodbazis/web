<?php

namespace Kodbazis\Generated\Episode\Patch;

use JsonSerializable;

class PatchedEpisode implements JsonSerializable
{
    private $title;
private $slug;
private $courseId;
private $imgUrl;
private $videoFileName;
private $description;
private $content;


    
public function __construct($title, $slug, $courseId, $imgUrl, $videoFileName, $description, $content)
{
        $this->title = $title;
$this->slug = $slug;
$this->courseId = $courseId;
$this->imgUrl = $imgUrl;
$this->videoFileName = $videoFileName;
$this->description = $description;
$this->content = $content;

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
    
    
    public function jsonSerialize()
    {
        return [
            'title' => $this->title,
 'slug' => $this->slug,
 'courseId' => $this->courseId,
 'imgUrl' => $this->imgUrl,
 'videoFileName' => $this->videoFileName,
 'description' => $this->description,
 'content' => $this->content,

        ];
    }
}
