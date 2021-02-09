<?php
    namespace Kodbazis\Generated\Quote\Patch;
    
    use Kodbazis\Generated\Quote\Quote;
    
    interface Patcher
    {
        function patch(string $id, PatchedQuote $quote): Quote;
    }
    