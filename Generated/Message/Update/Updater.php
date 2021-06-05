<?php
    namespace Kodbazis\Generated\Message\Update;
    
    use Kodbazis\Generated\Message\Message;
    
    interface Updater
    {
        function update(string $id, UpdatedMessage $message): Message;
    }
    