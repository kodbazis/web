<?php
    namespace Kodbazis\Generated\Comment\Update;
    
    use Kodbazis\Generated\Comment\Comment;
    
    interface Updater
    {
        function update(string $id, UpdatedComment $comment): Comment;
    }
    