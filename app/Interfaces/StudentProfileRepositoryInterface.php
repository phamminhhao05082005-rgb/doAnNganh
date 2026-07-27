<?php

namespace App\Interfaces;

use App\Models\User;


interface StudentProfileRepositoryInterface
{
   public function getProfile(User $user): User;

   public function update(User $user, array $data): User;

}