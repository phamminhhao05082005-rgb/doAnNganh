<?php

namespace App\Services;

use App\Models\Experience;
use App\Models\User;
use App\Interfaces\StudentExperienceRepositoryInterface;
use App\Interfaces\StudentExperienceServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Exception;

class StudentExperienceService implements StudentExperienceServiceInterface
{

    public function __construct(
        private StudentExperienceRepositoryInterface $repository
    ) {
        
    }

    public function getAll(User $user): Collection
    {
        return $this->repository->getAll($user);
    }

    public function create(User $user, array $data): Experience {
        $this->checkUserMatch($user);
        return $this->repository->create($user, $data);
    }

    public function update(User $user, Experience $experience, array $data): Experience {
        $this->checkOwner($user, $experience);
        return $this->repository->update($user, $experience, $data);
    }

    public function delete(User $user, Experience $experience): void {
        $this->checkOwner($user, $experience);
        $this->repository->delete($user, $experience);
    }

    private function checkOwner(User $user, Experience $experience): void
    {
        $this->checkUserMatch($user);

        $profile = $user->candidateProfile;
        if (!$profile || $experience->profile_id !== $profile->id) {
            throw new Exception("Bạn không có quyền truy cập và thay đổi.");
        }
    }

    private function checkUserMatch(User $user): void
    {
        $currentUser = Auth::user();

        if (!$currentUser || $currentUser->id !== $user->id) {
            throw new Exception("Unauthorized access.");
        }
    }
}