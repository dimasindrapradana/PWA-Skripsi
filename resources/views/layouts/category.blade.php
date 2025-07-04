@extends('layouts.app')

@section('title', 'Kategori: ' . $category->name)

@section('content')
@include('components.navbar')

<div class="min-h-screen flex flex-col bg-gray-50">

    <main class="flex-grow px-2 sm:px-6 py-8 max-w-5xl mx-auto w-full pb-24">
        <!-- Hero Section -->
        <section class="text-center mb-12">
            <h1 class="text-2xl sm:text-4xl font-bold text-gray-800">
                Pembelajaran Tahap {{ $category->name }}
            </h1>
            <p class="text-gray-600 mt-4 max-w-2xl mx-auto leading-relaxed text-justify">
                {{ $category->description }}
            </p>
            <div class="mt-6">
                <div class="w-32 h-2 bg-indigo-700 rounded-full mx-auto"></div>
            </div>
        </section>

        <!-- Informational Boxes -->
        <section class="mb-12">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Yang Akan Anda Dapatkan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Modul -->
                <div class="p-5 bg-white border rounded-xl shadow-sm flex flex-col justify-between h-full">
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Modul</h3>
                        <p class="text-sm text-gray-600">Materi bacaan elektronik disajikan dengan bahasa yang mudah dipahami.</p>
                    </div>
                </div>
                <!-- Video -->
                <div class="p-5 bg-white border rounded-xl shadow-sm flex flex-col justify-between h-full">
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Video</h3>
                        <p class="text-sm text-gray-600">Materi video singkat agar nyaman ditonton dan mudah dipraktikkan.</p>
                    </div>
                </div>
                <!-- Kuis -->
                <div class="p-5 bg-white border rounded-xl shadow-sm flex flex-col justify-between h-full">
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Kuis</h3>
                        <p class="text-sm text-gray-600 mb-3">Kuis membantu Anda memahami materi secara lebih mendalam.</p>
                    </div>
                    <div class="flex flex-col items-start">
                        <span class="text-xs text-slate-500 mb-2">Kuis bisa diakses disini!</span>
                        <a href="{{ route('quiz.index') }}"
                        class="inline-block bg-yellow-400 hover:bg-yellow-500 text-slate-900 font-semibold py-2 px-4 rounded-lg shadow-sm text-sm transition">
                            Lihat Kuis
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mulai Materi & Kuis Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
            @if ($category->materials->count() > 0)
                <a href="{{ url('/materi/' . $category->materials->first()->slug) }}"
                   class="inline-block bg-indigo-700 hover:bg-indigo-800 text-white font-bold py-3 px-6 rounded-xl shadow transition">
                    Mulai Materi
                </a>
            @endif
        </div>

       <section class="mb-12">
            <h2 class="text-xl font-semibold text-gray-800 mb-6 text-center">Urutan Materi</h2>
            <div class="w-full px-4 max-w-3xl mx-auto relative">
                <div class="absolute left-7 top-5 bottom-5 w-1 bg-indigo-200 rounded-full z-0 hidden sm:block"></div>
                <div class="flex flex-col gap-6 relative z-10">
                    @foreach ($category->materials as $index => $material)
                        <div class="relative flex items-start gap-4">
                            <!-- Bulatan Nomor -->
                            <div class="flex items-center justify-center w-10 h-10 flex-shrink-0 rounded-full bg-indigo-700 text-white font-bold text-sm border-4 border-white shadow">
                                {{ $loop->iteration }}
                            </div>
                            <!-- Konten -->
                            <div class="bg-white rounded-xl shadow-sm p-4 border border-slate-200 w-full">
                                <h4 class="text-base font-bold text-indigo-800 mb-1">{{ $material->title }}</h4>
                                <p class="text-sm text-gray-600">{{ Str::limit($material->description, 80) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>


    </main>
    @include('components.footer')
</div>
@include('components.mobile-navbar')
@endsection
