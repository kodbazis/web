<?php
    namespace Kodbazis\Generated\Course\Patch;
    
    use Kodbazis\Generated\Course\Course;
    
    interface Patcher
    {
        function patch(string $id, PatchedCourse $course): Course;
    }
    