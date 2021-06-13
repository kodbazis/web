<?php

namespace Kodbazis\Generated\Comment\Save;

use JsonSerializable;

class NewComment implements JsonSerializable
{
    private $content;
private $embeddableId;
private $key;
private $createdAt;


    
public function __construct($content, $embeddableId, $key, $createdAt)
{
        $this->content = $content;
$this->embeddableId = $embeddableId;
$this->key = $key;
$this->createdAt = $createdAt;

}
    
    public function getContent(): ?string
    {
        return $this->content;
    }
    public function getEmbeddableId(): ?int
    {
        return $this->embeddableId;
    }
    public function getKey(): ?string
    {
        return $this->key;
    }
    public function getCreatedAt(): ?int
    {
        return $this->createdAt;
    }
    
    
    public function jsonSerialize()
    {
        return [
            'content' => $this->content,
 'embeddableId' => $this->embeddableId,
 'key' => $this->key,
 'createdAt' => $this->createdAt,

        ];
    }
}
