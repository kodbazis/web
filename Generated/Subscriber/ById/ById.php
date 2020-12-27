<?php
    namespace Kodbazis\Generated\Subscriber\ById;
    
    use Kodbazis\Generated\Subscriber\Subscriber;
    
    interface ById
    {
        function byId(string $id): Subscriber;
    }
    