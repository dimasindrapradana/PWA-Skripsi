<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // kode yang ada...

    /**
     * Tempat untuk mengarahkan pengguna setelah login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('filament.pages.dashboard'); // Dashboard admin Filament
        } elseif ($user->role === 'user') {
            return redirect()->route('user.dashboard'); // Rute dashboard pengguna Anda
        }

        return redirect('/'); // Rute fallback
    }
}
