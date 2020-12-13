<?php

namespace Kodbazis\Generated\Feedback\Save;

use JsonSerializable;

class NewFeedback implements JsonSerializable
{
    private $name;
private $content;
private $episodeId;
private $createdAt;


    
public function __construct($name, $content, $episodeId, $createdAt)
{
        $this->name = $name;
$this->content = $content;
$this->episodeId = $episodeId;
$this->createdAt = $createdAt;

}
    
    public function getName(): ?string
    {
        return $this->name;
    }
    public function getContent(): ?string
    {
        return $this->content;
    }
    public function getEpisodeId(): ?int
    {
        return $this->episodeId;
    }
    public function getCreatedAt(): ?int
    {
        return $this->createdAt;
    }
    
    
    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
 'content' => $this->content,
 'episodeId' => $this->episodeId,
 'createdAt' => $this->createdAt,

        ];
    }
}
