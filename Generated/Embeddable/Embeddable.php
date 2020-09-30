<?php

namespace Kodbazis\Generated\Embeddable;

use JsonSerializable;

class Embeddable implements JsonSerializable
{
    private $id;
private $createdAt;
private $name;
private $raw;
private $type;


    
public function __construct($id, $createdAt, $name, $raw, $type)
{
        $this->id = $id;
$this->createdAt = $createdAt;
$this->name = $name;
$this->raw = $raw;
$this->type = $type;

}
    
    public function getId(): ?int
    {
        return $this->id;
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
            'id' => $this->id,
 'createdAt' => $this->createdAt,
 'name' => $this->name,
 'raw' => $this->raw,
 'type' => $this->type,

        ];
    }
}
