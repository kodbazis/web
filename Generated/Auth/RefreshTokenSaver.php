<?php

namespace Kodbazis\Generated\Auth;

interface RefreshTokenSaver
{
    public function save(RawToken $token): RefreshToken;
}