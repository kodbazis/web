<?php
    namespace Kodbazis\Generated\Post\Update;
    
    use Kodbazis\Generated\Post\Post;
    
    interface Updater
    {
        function update(string $id, UpdatedPost $post): Post;
    }
    