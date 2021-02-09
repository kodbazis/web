<?php
    namespace Kodbazis\Generated\Spec\Save;

    use Kodbazis\Generated\Spec\Spec;

    interface Saver
    {
        function Save(NewSpec $new): Spec;
    }
    