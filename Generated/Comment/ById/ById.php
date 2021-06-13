<?php
    namespace Kodbazis\Generated\Comment\ById;
    
    use Kodbazis\Generated\Comment\Comment;
    
    interface ById
    {
        function byId(string $id): Comment;
    }
    