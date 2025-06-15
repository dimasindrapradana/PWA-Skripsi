@extends('layouts.app')

@section('title', 'Landing Page')


@section('content')
<div class="bg-slate-900 min-h-screen flex items-center justify-center px-2">
    <div class="w-full max-w-sm mx-auto bg-white/95 rounded-2xl shadow-xl py-8 px-5 flex flex-col items-center">

        <h1 class="text-2xl md:text-3xl font-bold text-slate-900 text-center mb-4 leading-snug tracking-tight">
            Selamat Datang <br>
            di <span class="text-indigo-600">Ruang Fotografi SKAGATA</span>
        </h1>
        <p class="text-slate-600 text-center mb-7 text-base">
            Platform belajar <span class="font-medium text-indigo-700">Fotografi Dasar</span> berbasis Progressive Web App. Pilih login sesuai peranmu.
        </p>

        <a href="{{ route('login.user') }}"
           class="w-full text-center py-3 mb-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-lg shadow transition duration-150">
            Login Siswa
        </a>
        <a href="{{ route('filament.admin.auth.login') }}"
           class="w-full text-center py-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-lg shadow transition duration-150">
            Login Guru / Admin
        </a>

        <div class="mt-8 text-xs text-slate-400 text-center">
            &copy; {{ date('Y') }} Ruang Fotografi SKAGATA
        </div>
    </div>
</div>
@endsection
