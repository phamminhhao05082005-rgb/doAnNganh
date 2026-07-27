<?php

namespace App\Interfaces;

use App\Models\User;

interface StudentProfileServiceInterface
{
    public function getProfile(User $user): User;

    public function update(User $user, array $data): User;
}