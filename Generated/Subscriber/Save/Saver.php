<?php
    namespace Kodbazis\Generated\Subscriber\Save;

    use Kodbazis\Generated\Subscriber\Subscriber;

    interface Saver
    {
        function Save(NewSubscriber $new): Subscriber;
    }
    