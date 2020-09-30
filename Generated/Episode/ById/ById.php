<?php
    namespace Kodbazis\Generated\Episode\ById;
    
    use Kodbazis\Generated\Episode\Episode;
    
    interface ById
    {
        function byId(string $id): Episode;
    }
    