<?php
    namespace Kodbazis\Generated\Feedback\Patch;
    
    use Kodbazis\Generated\Feedback\Feedback;
    
    interface Patcher
    {
        function patch(string $id, PatchedFeedback $feedback): Feedback;
    }
    