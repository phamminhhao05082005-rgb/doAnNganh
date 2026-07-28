<?php

namespace App\Services;

use App\Interfaces\StudentProfileRepositoryInterface;
use App\Interfaces\StudentProfileServiceInterface;
use App\Models\User;

class StudentProfileService implements StudentProfileServiceInterface
{
    protected StudentProfileRepositoryInterface $repository;

    protected CloudinaryService $cloudinary;

    public function __construct(
        StudentProfileRepositoryInterface $repository,
        CloudinaryService $cloudinary
    ) {
        $this->repository = $repository;
        $this->cloudinary = $cloudinary;
    }

    public function getProfile(User $user): User
    {
        return $this->repository->getProfile($user);
    }

    public function update(
        User $user,
        array $data,
        $avatar = null
    ): User {

        if ($avatar) {

            $upload = $this->cloudinary->uploadFile(
                $avatar,
                'student_avatars'
            );

            $data['avatar'] = $upload['url'];
        }

        return $this->repository->update(
            $user,
            $data
        );
    }
}