<?php
    namespace Kodbazis\Generated\Episode\Update;
    
    use Kodbazis\Generated\Episode\Episode;
    
    interface Updater
    {
        function update(string $id, UpdatedEpisode $episode): Episode;
    }
    