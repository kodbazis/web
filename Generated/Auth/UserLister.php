<?php

namespace Kodbazis\Generated\Auth;


interface UserLister
{
    /**
     * @return User[]
     */
    public function listUsers(): array;
}
