<?php

namespace Kodbazis\Generated\Auth;

interface TokenVerifier
{
    public function verify(string $token): ?Claims;
}
