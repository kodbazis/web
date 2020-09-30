<?php
    namespace Kodbazis\Generated\Embeddable\Patch;
    
    use Kodbazis\Generated\Embeddable\Embeddable;
    
    interface Patcher
    {
        function patch(string $id, PatchedEmbeddable $embeddable): Embeddable;
    }
    