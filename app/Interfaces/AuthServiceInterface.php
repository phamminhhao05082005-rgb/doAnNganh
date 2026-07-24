<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface AuthServiceInterface
{
    public function login(string $email,string $password): array;

    public function me(User $user): User;

    public function logout(User $user): void;

    public function getAllUsers(): Collection;

    public function googleLogin(string $token): array;
}