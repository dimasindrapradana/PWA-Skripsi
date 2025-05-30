@extends('layouts.app')

@section('title', 'Kategori: ' . $category->name)

@section('content')
<div class="min-h-screen flex flex-col bg-gray-50">
    @include('components.navbar')

    <main class="flex-grow px-4 sm:px-6 py-12 max-w-4xl mx-auto">
        <!-- Hero Section -->
        <section class="text-center mb-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-800">
                Pembelajaran “{{ $category->name }}“
            </h1>
            <p class="text-gray-600 mt-4 max-w-2xl mx-auto leading-relaxed">
                {{ $category->long_description }}
            </p>
            <div class="mt-6">
                <div class="w-32 h-2 bg-blue-500 rounded-full mx-auto"></div>
            </div>
        </section>

        <!-- Informational Boxes -->
        <section class="mb-12">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Yang akan Anda dapatkan</h2>
            <div class="grid sm:grid-cols-3 gap-6">
                <div class="p-5 bg-white border rounded-xl shadow-sm">
                    <h3 class="font-semibold text-gray-800 mb-1">Modul</h3>
                    <p class="text-sm text-gray-600">Materi bacaan elektronik disajikan dengan bahasa yang mudah dipahami</p>
                </div>
                <div class="p-5 bg-white border rounded-xl shadow-sm">
                    <h3 class="font-semibold text-gray-800 mb-1">Video</h3>
                    <p class="text-sm text-gray-600">Materi video disajikan dengan durasi singkat agar nyaman ditonton</p>
                </div>
                <div class="p-5 bg-white border rounded-xl shadow-sm">
                    <h3 class="font-semibold text-gray-800 mb-1">Kuis</h3>
                    <p class="text-sm text-gray-600">Kuis pilihan ganda membantu Anda memahami materi yang dipelajari</p>
                </div>
            </div>
        </section>

        <!-- Mulai Materi Button -->
        @if ($category->materials->count() > 0)
        <div class="text-center mb-12">
            <a href="{{ url('/materi/' . $category->materials->first()->slug) }}"
               class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow transition">
                Mulai Materi
            </a>
        </div>
        @endif

        <!-- Learning Path -->
        <section class="mb-12">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Path Pembelajaran</h2>
            <ol class="space-y-4 border-l-2 border-blue-500 pl-4">
                @forelse ($category->materials as $material)
                    <li class="relative bg-white rounded-md shadow-sm p-4 border">
                        <span class="absolute -left-3 top-5 w-3 h-3 bg-blue-500 rounded-full"></span>
                        <h4 class="text-lg font-semibold text-blue-800">{{ $material->title }}</h4>
                        <p class="text-sm text-gray-600 mt-1">
                            {{ Str::limit($material->description, 120) }}
                        </p>
                    </li>
                @empty
                    <li class="text-gray-500 italic">Belum ada materi dalam kategori ini.</li>
                @endforelse
            </ol>
        </section>
    </main>

    @include('components.footer')
</div>
@endsection
