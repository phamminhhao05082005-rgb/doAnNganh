<?php

namespace App\Services;
use Exception;
use App\Interfaces\StudentProfileRepositoryInterface;
use App\Interfaces\StudentProfileServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StudentProfileService implements StudentProfileServiceInterface
{

    public function __construct(private StudentProfileRepositoryInterface $repository,
        private CloudinaryService $cloudinary) {
       
    }

    public function getProfile(User $user): User
    {
        return $this->repository->getProfile($user);
    }

    public function update(User $user, array $data, $avatar = null): User {

        $this->checkOwner($user);

        if ($avatar) {
            $upload = $this->cloudinary->uploadFile($avatar, 'student_avatars');
            $data['avatar'] = $upload['url'];
        }

        return $this->repository->update($user, $data);
    }

    private function checkOwner(User $targetUser): void
    {
        $currentUser = Auth::user();

        if (!$currentUser || $currentUser->id !== $targetUser->id) {
            throw new Exception("You cannot update this profile.");
        }
    }
}