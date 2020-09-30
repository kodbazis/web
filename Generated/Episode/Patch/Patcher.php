<?php
    namespace Kodbazis\Generated\Episode\Patch;
    
    use Kodbazis\Generated\Episode\Episode;
    
    interface Patcher
    {
        function patch(string $id, PatchedEpisode $episode): Episode;
    }
    