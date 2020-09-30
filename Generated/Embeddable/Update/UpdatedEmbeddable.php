<?php

namespace Kodbazis\Generated\Embeddable\Update;

use JsonSerializable;

class UpdatedEmbeddable implements JsonSerializable
{
    private $name;
private $raw;
private $type;


    
public function __construct($name, $raw, $type)
{
        $this->name = $name;
$this->raw = $raw;
$this->type = $type;

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
            'name' => $this->name,
 'raw' => $this->raw,
 'type' => $this->type,

        ];
    }
}
