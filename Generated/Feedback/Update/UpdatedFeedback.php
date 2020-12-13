<?php

namespace Kodbazis\Generated\Feedback\Update;

use JsonSerializable;

class UpdatedFeedback implements JsonSerializable
{
    private $episodeId;


    
public function __construct($episodeId)
{
        $this->episodeId = $episodeId;

}
    
    public function getEpisodeId(): ?int
    {
        return $this->episodeId;
    }
    
    
    public function jsonSerialize()
    {
        return [
            'episodeId' => $this->episodeId,

        ];
    }
}
