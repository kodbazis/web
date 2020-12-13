<?php

namespace Kodbazis\Generated\Feedback\Patch;

use JsonSerializable;

class PatchedFeedback implements JsonSerializable
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
