<?php
    namespace Kodbazis\Generated\Message\ById;
    
    use Kodbazis\Generated\Message\Message;
    
    interface ById
    {
        function byId(string $id): Message;
    }
    