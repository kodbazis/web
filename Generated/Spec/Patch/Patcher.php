<?php
    namespace Kodbazis\Generated\Spec\Patch;
    
    use Kodbazis\Generated\Spec\Spec;
    
    interface Patcher
    {
        function patch(string $id, PatchedSpec $spec): Spec;
    }
    