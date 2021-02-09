<?php
    namespace Kodbazis\Generated\Spec\Update;
    
    use Kodbazis\Generated\Spec\Spec;
    
    interface Updater
    {
        function update(string $id, UpdatedSpec $spec): Spec;
    }
    