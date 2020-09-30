<?php
    namespace Kodbazis\Generated\Episode\Save;

    use Kodbazis\Generated\Episode\Episode;

    interface Saver
    {
        function Save(NewEpisode $new): Episode;
    }
    