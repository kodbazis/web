<?php

namespace Kodbazis\Generated\Embeddable\Save;

use JsonSerializable;

class NewEmbeddable implements JsonSerializable
{
    private $createdAt;
private $name;
private $raw;
private $type;


    
public function __construct($createdAt, $name, $raw, $type)
{
        $this->createdAt = $createdAt;
$this->name = $name;
$this->raw = $raw;
$this->type = $type;

}
    
    public function getCreatedAt(): ?int
    {
        return $this->createdAt;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    public function getRaw(): ?string
    {
        return $this->raw;
    }
    public function getType(): ?string
    {
        return $this->type;
    }
    
    
    public function jsonSerialize()
    {
        return [
            'createdAt' => $this->createdAt,
 'name' => $this->name,
 'raw' => $this->raw,
 'type' => $this->type,

        ];
    }
}
