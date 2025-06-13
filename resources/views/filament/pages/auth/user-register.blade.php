@extends('layouts.app')

@section('title', 'Register Siswa')

@section('content')
<div class="min-h-screen flex items-center justify-center px-2 sm:px-4 py-8 bg-gradient-to-br from-indigo-900 via-slate-900 to-slate-800">
    <div class="w-full max-w-sm bg-white/90 backdrop-blur-xl rounded-2xl p-8 sm:p-10 shadow-xl">
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight text-center mb-8">Register Siswa</h1>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-2 rounded-lg mb-4 text-center text-sm w-full">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register.user.submit') }}" class="space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-xs font-medium text-slate-700 mb-1">Nama Lengkap</label>
                <input id="name" type="text" name="name" required value="{{ old('name') }}"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-400 transition text-sm"
                    placeholder="Nama Lengkap">
            </div>
            <div>
                <label for="email" class="block text-xs font-medium text-slate-700 mb-1">Email</label>
                <input id="email" type="email" name="email" required value="{{ old('email') }}"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-400 transition text-sm"
                    placeholder="email@example.com">
            </div>
            <div>
                <label for="password" class="block text-xs font-medium text-slate-700 mb-1">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-400 transition text-sm"
                    placeholder="Minimal 8 karakter">
            </div>
            <div>
                <label for="password_confirmation" class="block text-xs font-medium text-slate-700 mb-1">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-400 transition text-sm"
                    placeholder="Ulangi Password">
            </div>
            <button type="submit"
                class="w-full bg-indigo-600 text-white py-2.5 rounded-lg font-bold tracking-wide shadow hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-400 focus:outline-none transition-all">
                Daftar
            </button>
        </form>

        <div class="mt-6 text-center text-xs text-slate-500 w-full">
            Sudah punya akun?
            <a href="{{ route('login.user') }}" class="text-indigo-600 font-semibold hover:underline">Login di sini</a>
        </div>
    </div>
</div>
@endsection
