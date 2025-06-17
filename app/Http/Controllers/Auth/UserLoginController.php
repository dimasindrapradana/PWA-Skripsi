<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('filament.pages.auth.user-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->intended('/admin'); // Filament Panel
        }

        return redirect()->route('user.dashboard'); // Dashboard siswa
     }
}

