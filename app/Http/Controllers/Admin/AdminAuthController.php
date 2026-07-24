<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {
    }

    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        try {
            $user = $this->authService->loginAdmin(
                $request->email,
                $request->password
            );

            if ($user->role->name !== 'ADMIN') {
                throw ValidationException::withMessages([
                    'email' => ['Bạn không có quyền truy cập trang quản trị.'],
                ]);
            }

            Auth::login($user);

            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}