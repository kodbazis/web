<?php
    namespace Kodbazis\Generated\Embeddable\ById;
    
    use Kodbazis\Generated\Embeddable\Embeddable;
    
    interface ById
    {
        function byId(string $id): Embeddable;
    }
    