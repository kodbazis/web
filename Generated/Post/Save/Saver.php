<?php
    namespace Kodbazis\Generated\Post\Save;

    use Kodbazis\Generated\Post\Post;

    interface Saver
    {
        function Save(NewPost $new): Post;
    }
    