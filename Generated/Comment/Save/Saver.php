<?php
    namespace Kodbazis\Generated\Comment\Save;

    use Kodbazis\Generated\Comment\Comment;

    interface Saver
    {
        function Save(NewComment $new): Comment;
    }
    