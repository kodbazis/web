<?php
    namespace Kodbazis\Generated\Comment\Patch;
    
    use Kodbazis\Generated\Comment\Comment;
    
    interface Patcher
    {
        function patch(string $id, PatchedComment $comment): Comment;
    }
    