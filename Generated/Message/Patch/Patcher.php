<?php
    namespace Kodbazis\Generated\Message\Patch;
    
    use Kodbazis\Generated\Message\Message;
    
    interface Patcher
    {
        function patch(string $id, PatchedMessage $message): Message;
    }
    