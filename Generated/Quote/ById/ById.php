<?php
    namespace Kodbazis\Generated\Quote\ById;
    
    use Kodbazis\Generated\Quote\Quote;
    
    interface ById
    {
        function byId(string $id): Quote;
    }
    