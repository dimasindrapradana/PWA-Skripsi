@extends('layouts.app')

@section('title', 'Lupa Password')

@section('content')
<div class="min-h-screen flex items-center justify-center px-2 sm:px-4 py-8 bg-gradient-to-br from-indigo-900 via-slate-900 to-slate-800">
    <div class="w-full max-w-sm bg-white/90 backdrop-blur-xl rounded-2xl p-8 sm:p-10 shadow-xl">
        <h1 class="text-xl font-bold text-center text-slate-800 mb-6">Reset Password</h1>

        @if (session('status'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm text-center">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-xs font-medium text-slate-700 mb-1">Email</label>
                <input id="email" type="email" name="email" required autofocus
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-400 transition text-sm"
                    placeholder="email@example.com"
                    value="{{ old('email') }}">
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 text-white py-2.5 rounded-lg font-bold tracking-wide shadow hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-400 focus:outline-none transition-all">
                Kirim Link Reset Password
            </button>
        </form>

        <div class="mt-6 text-center text-xs text-slate-500">
            Sudah ingat password?
            <a href="{{ route('login.user') }}" class="text-indigo-600 font-semibold hover:underline">Kembali ke Login</a>
        </div>
    </div>
</div>
@endsection
