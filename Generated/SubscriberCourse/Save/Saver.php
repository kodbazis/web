<?php
    namespace Kodbazis\Generated\SubscriberCourse\Save;

    use Kodbazis\Generated\SubscriberCourse\SubscriberCourse;

    interface Saver
    {
        function Save(NewSubscriberCourse $new): SubscriberCourse;
    }
    