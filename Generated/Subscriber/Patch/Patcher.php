<?php
    namespace Kodbazis\Generated\Subscriber\Patch;
    
    use Kodbazis\Generated\Subscriber\Subscriber;
    
    interface Patcher
    {
        function patch(string $id, PatchedSubscriber $subscriber): Subscriber;
    }
    