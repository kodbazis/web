<?php
    namespace Kodbazis\Generated\Course\Update;
    
    use Kodbazis\Generated\Course\Course;
    
    interface Updater
    {
        function update(string $id, UpdatedCourse $course): Course;
    }
    