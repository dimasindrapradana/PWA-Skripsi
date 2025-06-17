@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="min-h-screen flex items-center justify-center px-2 sm:px-4 py-8 bg-gradient-to-br from-indigo-900 via-slate-900 to-slate-800">
    <div class="w-full max-w-sm bg-white/90 backdrop-blur-xl rounded-2xl p-8 sm:p-10 shadow-xl">
        <h1 class="text-xl font-bold text-center text-slate-800 mb-6">Setel Ulang Password</h1>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div>
                <label for="password" class="block text-xs font-medium text-slate-700 mb-1">Password Baru</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-400 transition text-sm"
                    placeholder="masukkan password baru">
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-medium text-slate-700 mb-1">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-400 transition text-sm"
                    placeholder="ulangi password baru">
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 text-white py-2.5 rounded-lg font-bold tracking-wide shadow hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-400 focus:outline-none transition-all">
                Reset Password
            </button>
        </form>
    </div>
</div>
@endsection
