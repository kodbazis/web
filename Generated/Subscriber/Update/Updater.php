<?php
    namespace Kodbazis\Generated\Subscriber\Update;
    
    use Kodbazis\Generated\Subscriber\Subscriber;
    
    interface Updater
    {
        function update(string $id, UpdatedSubscriber $subscriber): Subscriber;
    }
    