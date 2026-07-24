<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email): ?User
    {
        return User::with('role')->where('email', $email)->first();
    }

    public function findById(int $id): ?User
    {
        return User::with('role')->find($id);
    }

    public function findAll(): Collection
    {
        return User::with('role')->orderBy('id')->get();
    }
}
