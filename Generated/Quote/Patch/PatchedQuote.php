<?php

namespace Kodbazis\Generated\Quote\Patch;

use JsonSerializable;

class PatchedQuote implements JsonSerializable
{
    private $position;
private $courseId;


    
public function __construct($position, $courseId)
{
        $this->position = $position;
$this->courseId = $courseId;

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
            'position' => $this->position,
 'courseId' => $this->courseId,

        ];
    }
}
