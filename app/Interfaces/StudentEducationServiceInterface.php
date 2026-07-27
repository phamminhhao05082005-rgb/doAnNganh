<?php

namespace App\Interfaces;

use App\Models\Education;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface StudentEducationServiceInterface
{
    public function getAll(User $user): Collection;

    public function create(User $user, array $data): Education;

    public function update(User $user, Education $education, array $data): Education;

    public function delete(User $user, Education $education): void;
}