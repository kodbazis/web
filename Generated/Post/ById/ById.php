<?php
    namespace Kodbazis\Generated\Post\ById;
    
    use Kodbazis\Generated\Post\Post;
    
    interface ById
    {
        function byId(string $id): Post;
    }
    