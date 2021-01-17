<?php
    namespace Kodbazis\Generated\SubscriberCourse\Patch;
    
    use Kodbazis\Generated\SubscriberCourse\SubscriberCourse;
    
    interface Patcher
    {
        function patch(string $id, PatchedSubscriberCourse $subscriberCourse): SubscriberCourse;
    }
    