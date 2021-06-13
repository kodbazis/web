<?php

namespace Kodbazis\Generated\Comment;

use JsonSerializable;

class Comment implements JsonSerializable
{
    private $id;
private $content;
private $embeddableId;
private $key;
private $createdAt;


    
public function __construct($id, $content, $embeddableId, $key, $createdAt)
{
        $this->id = $id;
$this->content = $content;
$this->embeddableId = $embeddableId;
$this->key = $key;
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
            'id' => $this->id,
 'content' => $this->content,
 'embeddableId' => $this->embeddableId,
 'key' => $this->key,
 'createdAt' => $this->createdAt,

        ];
    }
}
