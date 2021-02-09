<?php

namespace Kodbazis\Generated\Spec;

use JsonSerializable;

class Spec implements JsonSerializable
{
    private $id;
private $content;
private $position;
private $courseId;
private $createdAt;


    
public function __construct($id, $content, $position, $courseId, $createdAt)
{
        $this->id = $id;
$this->content = $content;
$this->position = $position;
$this->courseId = $courseId;
$this->createdAt = $createdAt;

}
    
    public function getId(): ?int
    {
        return $this->id;
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
            'id' => $this->id,
 'content' => $this->content,
 'position' => $this->position,
 'courseId' => $this->courseId,
 'createdAt' => $this->createdAt,

        ];
    }
}
