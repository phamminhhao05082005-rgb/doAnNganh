<?php

namespace App\Interfaces;

use App\Models\Experience;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface StudentExperienceServiceInterface
{
    public function getAll(User $user): Collection;

    public function create(User $user, array $data): Experience;

    public function update(
        User $user,
        Experience $experience,
        array $data
    ): Experience;

    public function delete(
        User $user,
        Experience $experience
    ): void;
}