<?php

namespace App\Services;

use App\Interfaces\AuthServiceInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Collection;
use Google\Client;
use App\Models\Role;

class AuthService implements AuthServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function login(string $email, string $password): array
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email hoặc mật khẩu không đúng.']
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function loginAdmin(string $email, string $password): User
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email hoặc mật khẩu không đúng.'],
            ]);
        }

        return $user;
    }

    public function me(User $user): User
    {
        return $this->userRepository->findById($user->id);
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }

    public function getAllUsers(): Collection
    {
        return $this->userRepository->findAll();
    }

    public function googleLogin(string $googleToken): array
    {
        $client = new Client([
            'client_id' => env('GOOGLE_CLIENT_ID')
        ]);

        $payload = $client->verifyIdToken($googleToken);

        if (!$payload) {
            throw ValidationException::withMessages([
                'token' => ['Google Token không hợp lệ']
            ]);
        }

        $email = $payload['email'];

        if (!str_ends_with($email, '@ou.edu.vn')) {
            throw ValidationException::withMessages([
                'email' => ['Chỉ sinh viên OU mới được đăng nhập bằng Google']
            ]);
        }

        $user = $this->userRepository->findByEmail($email);

        if (!$user) {

            $studentRole = Role::where('name', 'STUDENT')->first();

            $user = User::create([

                'role_id' => $studentRole->id,
                'full_name' => $payload['name'],
                'email' => $email,
                'password' => bcrypt(fake()->password()),
                'avatar' => $payload['picture'],
                'provider' => 'google',
                'status' => true

            ]);

            $user->load('role');
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user];
    }
}
