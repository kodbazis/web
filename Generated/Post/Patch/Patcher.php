<?php
    namespace Kodbazis\Generated\Post\Patch;
    
    use Kodbazis\Generated\Post\Post;
    
    interface Patcher
    {
        function patch(string $id, PatchedPost $post): Post;
    }
    