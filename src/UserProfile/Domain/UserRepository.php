<?php

namespace Afsy\UserProfile\Domain;

interface UserRepository
{
    public function find($userId);

    public function save(User $user);
}
