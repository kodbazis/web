<?php
    namespace Kodbazis\Generated\Feedback\ById;
    
    use Kodbazis\Generated\Feedback\Feedback;
    
    interface ById
    {
        function byId(string $id): Feedback;
    }
    