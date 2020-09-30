<?php

namespace Kodbazis\Generated\Auth;

interface TokenGetter
{
    function getAccessToken(string $userId): AccessToken;

    function getRefreshToken(): RefreshToken;
}