<?php

namespace Kodbazis\Generated\Auth;

interface RawTokenGetter
{
    public function getRawToken(string $refreshTokenValue): ?RawToken;
}