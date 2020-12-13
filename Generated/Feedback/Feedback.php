<?php

namespace Kodbazis\Generated\Feedback;

use JsonSerializable;

class Feedback implements JsonSerializable
{
    private $id;
private $name;
private $content;
private $episodeId;
private $createdAt;


    
public function __construct($id, $name, $content, $episodeId, $createdAt)
{
        $this->id = $id;
$this->name = $name;
$this->content = $content;
$this->episodeId = $episodeId;
$this->createdAt = $createdAt;

}
    
    public function getId(): ?int
    {
        return $this->id;
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
            'id' => $this->id,
 'name' => $this->name,
 'content' => $this->content,
 'episodeId' => $this->episodeId,
 'createdAt' => $this->createdAt,

        ];
    }
}
