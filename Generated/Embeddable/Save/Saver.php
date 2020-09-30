<?php
    namespace Kodbazis\Generated\Embeddable\Save;

    use Kodbazis\Generated\Embeddable\Embeddable;

    interface Saver
    {
        function Save(NewEmbeddable $new): Embeddable;
    }
    