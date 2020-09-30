<?php

namespace Kodbazis\Generated\Auth;

interface TokenDeleter
{
    public function delete(RefreshToken $token): ?RawToken;
}