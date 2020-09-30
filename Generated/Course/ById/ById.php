<?php
    namespace Kodbazis\Generated\Course\ById;
    
    use Kodbazis\Generated\Course\Course;
    
    interface ById
    {
        function byId(string $id): Course;
    }
    