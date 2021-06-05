<?php
    namespace Kodbazis\Generated\Message\Save;

    use Kodbazis\Generated\Message\Message;

    interface Saver
    {
        function Save(NewMessage $new): Message;
    }
    