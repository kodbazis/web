<?php
    namespace Kodbazis\Generated\Course\Save;

    use Kodbazis\Generated\Course\Course;

    interface Saver
    {
        function Save(NewCourse $new): Course;
    }
    