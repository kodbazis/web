<?php

namespace Kodbazis\Generated\Auth;

interface UserByEmailGetter
{
    public function getUser(string $email): User;
}