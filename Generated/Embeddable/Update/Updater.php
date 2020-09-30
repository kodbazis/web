<?php
    namespace Kodbazis\Generated\Embeddable\Update;
    
    use Kodbazis\Generated\Embeddable\Embeddable;
    
    interface Updater
    {
        function update(string $id, UpdatedEmbeddable $embeddable): Embeddable;
    }
    