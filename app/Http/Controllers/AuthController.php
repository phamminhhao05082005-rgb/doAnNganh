<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\UserResource;
use App\Interfaces\AuthServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\Auth\GoogleLoginRequest;

class AuthController extends Controller
{
    public function __construct(
        private AuthServiceInterface $authService
    ) {}

    public function login(LoginRequest $request): LoginResource
    {
        $result = $this->authService->login($request->email, $request->password);
        return new LoginResource($result);
    }

    public function me(Request $request): UserResource
    {
        $user = $this->authService->me($request->user());
        return new UserResource($user);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());
        return response()->json([
            'message' => 'Đăng xuất thành công'
        ]);
    }

    public function index(): AnonymousResourceCollection
    {
        $users = $this->authService->getAllUsers();
        return UserResource::collection($users);
    }

    public function googleLogin(GoogleLoginRequest $request): LoginResource {
        $result = $this->authService->googleLogin($request->token);
        return new LoginResource($result);
    }
}
