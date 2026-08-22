<?php

namespace App\Interfaces;

use App\Models\CV;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface CVServiceInterface
{
    public function getMyCVs(
        User $user
    ): Collection;

    public function findById(
        int $id
    ): CV;

    public function create(
        User $user,
        array $data
    ): CV;

    public function update(
        User $user,
        int $id,
        array $data
    ): CV;

    public function delete(User $user, int $id): bool;
}