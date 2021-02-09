<?php

namespace Kodbazis\Generated\Spec\Patch;

use JsonSerializable;

class PatchedSpec implements JsonSerializable
{
    private $content;
private $position;
private $courseId;


    
public function __construct($content, $position, $courseId)
{
        $this->content = $content;
$this->position = $position;
$this->courseId = $courseId;

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
    
    
    public function jsonSerialize()
    {
        return [
            'content' => $this->content,
 'position' => $this->position,
 'courseId' => $this->courseId,

        ];
    }
}
