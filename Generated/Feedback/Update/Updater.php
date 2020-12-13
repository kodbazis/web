<?php
    namespace Kodbazis\Generated\Feedback\Update;
    
    use Kodbazis\Generated\Feedback\Feedback;
    
    interface Updater
    {
        function update(string $id, UpdatedFeedback $feedback): Feedback;
    }
    