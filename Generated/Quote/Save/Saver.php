<?php
    namespace Kodbazis\Generated\Quote\Save;

    use Kodbazis\Generated\Quote\Quote;

    interface Saver
    {
        function Save(NewQuote $new): Quote;
    }
    