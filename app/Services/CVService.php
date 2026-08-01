<?php

namespace App\Services;

use App\Models\CV;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\CVServiceInterface;
use App\Interfaces\CVRepositoryInterface;
use App\Models\CVEducation;
use App\Models\CVExperience;
use Illuminate\Support\Facades\DB;

class CVService
implements CVServiceInterface
{
    protected CVRepositoryInterface $repository;

    public function __construct(
        CVRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function getMyCVs(
        User $user
    ): Collection {
        return $this->repository
            ->getMyCVs($user->id);
    }

    public function findById(int $id): CV
    {
        return $this->repository
            ->findById($id)
            ->load([
                'template',
                'educations',
                'experiences'
            ]);
    }

    public function create(
        User $user,
        array $data
    ): CV {

        $user->load([
            "candidateProfile.educations",
            "candidateProfile.experiences"
        ]);

        $profile = $user->candidateProfile;

        $data = array_merge([

            "user_id" => $user->id,

            'profile_id' => $profile->id,

            "title" => "CV của " . $user->full_name,

            "full_name" => $user->full_name,

            "email" => $user->email,

            "phone" => $user->phone,

            "avatar" => $user->avatar,

            "job_title" => $profile?->title,

            "summary" => $profile?->summary,

            "experience_year" => $profile?->experience_year,

            "expected_salary" => $profile?->expected_salary,

            "status" => true

        ], $data);

        return DB::transaction(function () use ($data, $profile) {


            $cv = $this->repository->create($data);

            if ($profile) {

                foreach ($profile->educations as $edu) {

                    CVEducation::create([

                        'cv_id' => $cv->id,

                        'school_name' => $edu->school_name,

                        'major' => $edu->major,

                        'degree' => $edu->degree,

                        'gpa' => $edu->gpa,

                        'start_date' => $edu->start_date,

                        'end_date' => $edu->end_date

                    ]);
                }

                foreach ($profile->experiences as $exp) {

                    CVExperience::create([

                        "cv_id" => $cv->id,

                        "company_name" => $exp->company_name,

                        "position" => $exp->position,

                        "start_date" => $exp->start_date,

                        "end_date" => $exp->end_date,

                        "description" => $exp->description

                    ]);
                }
            }

            return $cv;
        });
    }

    public function update(
        User $user,
        int $id,
        array $data
    ): CV {
        $cv = $this->repository
            ->findById($id);

        if ($cv->user_id != $user->id) {
            abort(403);
        }

        return $this->repository
            ->update($cv, $data);
    }

    public function delete(
        int $id
    ): bool {
        $cv = $this->repository
            ->findById($id);

        return $this->repository
            ->delete($cv);
    }
}
