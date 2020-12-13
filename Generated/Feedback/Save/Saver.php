<?php
    namespace Kodbazis\Generated\Feedback\Save;

    use Kodbazis\Generated\Feedback\Feedback;

    interface Saver
    {
        function Save(NewFeedback $new): Feedback;
    }
    