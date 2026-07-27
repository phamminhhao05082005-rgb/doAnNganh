<?php

namespace App\Repositories;

use App\Models\CandidateProfile;
use App\Models\Education;
use App\Models\User;
use App\Interfaces\StudentEducationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class StudentEducationRepository implements StudentEducationRepositoryInterface
{
    public function getAll(User $user): Collection
    {
        $profile = CandidateProfile::firstOrCreate([
            'user_id' => $user->id
        ]);

        return $profile->educations()->latest()->get();
    }

    public function create(User $user, array $data): Education
    {
        $profile = CandidateProfile::firstOrCreate([
            'user_id' => $user->id
        ]);

        return $profile->educations()->create([
            'school' => $data['school'],
            'major' => $data['major'],
            'start_year' => $data['start_year'],
            'end_year' => $data['end_year'],
        ]);
    }

    public function update(
        User $user,
        Education $education,
        array $data
    ): Education {

        $education = $this->findEducationOfUser($user, $education);

        DB::transaction(function () use ($education, $data) {

            $education->update([
                'school' => $data['school'],
                'major' => $data['major'],
                'start_year' => $data['start_year'],
                'end_year' => $data['end_year'],
            ]);
        });

        return $education->fresh();
    }

    public function delete(User $user, Education $education): void
    {
        $education = $this->findEducationOfUser($user, $education);

        $education->delete();
    }

    private function findEducationOfUser(
        User $user,
        Education $education
    ): Education {

        $profile = CandidateProfile::where('user_id', $user->id)->first();

        if (!$profile) {
            throw new ModelNotFoundException();
        }

        $education = $profile->educations()
            ->where('id', $education->id)
            ->first();

        if (!$education) {
            throw new ModelNotFoundException();
        }

        return $education;
    }
}