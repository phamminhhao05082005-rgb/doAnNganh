<?php

namespace App\Repositories;

use App\Interfaces\StudentProfileRepositoryInterface;
use App\Models\CandidateProfile;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StudentProfileRepository implements StudentProfileRepositoryInterface
{
    public function getProfile(User $user): User
    {
        return User::with('candidateProfile')
            ->findOrFail($user->id);
    }

    public function update(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data) {

            $user->update([
                'full_name' => $data['full_name'],
                'phone' => $data['phone'] ?? null,
                'avatar' => $data['avatar'] ?? $user->avatar,
            ]);

            $profile = CandidateProfile::firstOrCreate(
                [
                    'user_id' => $user->id
                ]
            );

            $profile->update([
                'title' => $data['title'] ?? null,
                'summary' => $data['summary'] ?? null,
                'experience_year' => $data['experience_year'] ?? 0,
                'expected_salary' => $data['expected_salary'] ?? 0,
            ]);

            return $this->getProfile($user->fresh());
        });
    }
}
