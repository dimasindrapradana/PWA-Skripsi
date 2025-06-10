@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
{{-- Navbar --}}
    @include('components.navbar')
<div class="min-h-screen flex flex-col bg-gray-50">
    {{-- Main Content --}}
    <main class="flex-grow px-4 sm:px-6 py-8 max-w-7xl mx-auto">
        <div class="mb-10 text-center">
            <h1 class="text-5xl font-bold text-gray-900  mb-2">Selamat Datang, {{ auth()->user()->name }}!</h1>
            <p class="text-gray-900 ">Mulailah belajar fotografi dasar disini</p>
        </div>
        <div class="flex gap-6 overflow-x-auto pb-2">
            @foreach ($categories as $category)
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm min-w-[260px] max-w-xs w-full p-6 transition hover:shadow-md">
                    <h2 class="text-lg font-semibold text-gray-900 mb-1">{{ $category->name }}</h2>
                    <p class="text-gray-600 text-sm mb-4">{{ $category->description }}</p>
                    <a href="{{ route('kategori.show', $category->slug) }}"
                       class="block text-center bg-slate-900 hover:bg-slate-700 text-white font-medium py-2 rounded-lg shadow transition">
                        Lihat Materi
                    </a>
                </div>
            @endforeach
        </div>
    </main>

    @include('components.footer')
</div>
@endsection
