<?php
    namespace Kodbazis\Generated\Quote\Update;
    
    use Kodbazis\Generated\Quote\Quote;
    
    interface Updater
    {
        function update(string $id, UpdatedQuote $quote): Quote;
    }
    