<?php
    namespace Kodbazis\Generated\SubscriberCourse\Update;
    
    use Kodbazis\Generated\SubscriberCourse\SubscriberCourse;
    
    interface Updater
    {
        function update(string $id, UpdatedSubscriberCourse $subscriberCourse): SubscriberCourse;
    }
    