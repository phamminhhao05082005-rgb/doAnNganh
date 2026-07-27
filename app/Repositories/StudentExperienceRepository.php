<?php

namespace App\Repositories;

use App\Models\CandidateProfile;
use App\Models\Experience;
use App\Models\User;
use App\Interfaces\StudentExperienceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class StudentExperienceRepository implements StudentExperienceRepositoryInterface
{
    public function getAll(User $user): Collection
    {
        $profile = CandidateProfile::firstOrCreate([
            'user_id' => $user->id
        ]);

        return $profile->experiences()
            ->latest()
            ->get();
    }

    public function create(User $user, array $data): Experience
    {
        $profile = CandidateProfile::firstOrCreate([
            'user_id' => $user->id
        ]);

        return $profile->experiences()->create([
            'company_name' => $data['company_name'],
            'position' => $data['position'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'] ?? null,
            'description' => $data['description'] ?? null,
        ]);
    }

    public function update(
        User $user,
        Experience $experience,
        array $data
    ): Experience {

        $experience = $this->findExperienceOfUser(
            $user,
            $experience
        );

        DB::transaction(function () use ($experience, $data) {

            $experience->update([
                'company_name' => $data['company_name'],
                'position' => $data['position'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'] ?? null,
                'description' => $data['description'] ?? null,
            ]);

        });

        return $experience->fresh();
    }

    public function delete(
        User $user,
        Experience $experience
    ): void {

        $experience = $this->findExperienceOfUser(
            $user,
            $experience
        );

        $experience->delete();
    }

    private function findExperienceOfUser(
        User $user,
        Experience $experience
    ): Experience {

        $profile = CandidateProfile::where(
            'user_id',
            $user->id
        )->first();

        if (!$profile) {
            throw new ModelNotFoundException();
        }

        $experience = $profile->experiences()
            ->where('id', $experience->id)
            ->first();

        if (!$experience) {
            throw new ModelNotFoundException();
        }

        return $experience;
    }
}