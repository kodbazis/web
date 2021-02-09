<?php

namespace Kodbazis\Generated\Spec\Save;

use JsonSerializable;

class NewSpec implements JsonSerializable
{
    private $content;
private $position;
private $courseId;
private $createdAt;


    
public function __construct($content, $position, $courseId, $createdAt)
{
        $this->content = $content;
$this->position = $position;
$this->courseId = $courseId;
$this->createdAt = $createdAt;

}
    
    public function getContent(): ?string
    {
        return $this->content;
    }
    public function getPosition(): ?int
    {
        return $this->position;
    }
    public function getCourseId(): ?int
    {
        return $this->courseId;
    }
    public function getCreatedAt(): ?int
    {
        return $this->createdAt;
    }
    
    
    public function jsonSerialize()
    {
        return [
            'content' => $this->content,
 'position' => $this->position,
 'courseId' => $this->courseId,
 'createdAt' => $this->createdAt,

        ];
    }
}
