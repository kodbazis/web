<?php
    namespace Kodbazis\Generated\SubscriberCourse\ById;
    
    use Kodbazis\Generated\SubscriberCourse\SubscriberCourse;
    
    interface ById
    {
        function byId(string $id): SubscriberCourse;
    }
    