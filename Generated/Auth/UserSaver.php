<?php

namespace Kodbazis\Generated\Auth;

interface UserSaver
{
    public function save(NewUser $user): User;
}