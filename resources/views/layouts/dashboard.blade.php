@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="min-h-screen flex flex-col bg-gray-50">

    @include('components.navbar')

    <main class="flex-grow px-4 sm:px-6 py-8 max-w-7xl mx-auto">
        <div class="container mx-auto">
            {{-- Hero Section --}}
            <div class="mb-10 text-center">
                <h1 class="text-3xl font-bold text-gray-800">Selamat datang, {{ auth()->user()->name }}!</h1>
                <p class="text-gray-600 mt-2">Mulailah belajar fotografi sesuai urutan pembelajaran.</p>
            </div>

    
            {{-- <div class="relative">
                <!-- Tombol kiri -->
                <button id="scrollLeft" class="carousel-arrow left-0">
                    &#8592;
                </button> --}}

                <!-- Scroll Wrapper -->
                <div id="categoryScrollWrapper" class="category-scroll-wrapper overflow-x-auto">
                    <div class="category-scroll flex gap-4">
                        @foreach ($categories as $category)
                        <div class="category-card shrink-0">
                            <div class="p-6">
                                <h2 class="text-lg font-bold text-gray-800">{{ $category->name }}</h2>
                                <p class="text-gray-600 text-sm mt-1">{{ $category->description }}</p>
                            </div>
                            <div class="p-5 pt-0">
                                <a href="{{ route('kategori.show', $category->slug) }}"
                                class="block text-center bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2 rounded transition">
                                Lihat Materi
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Tombol kanan -->
                {{-- <button id="scrollRight" class="carousel-arrow right-0">
                    &#8594;
                </button>
            </div> --}}
        </div>
    </main>

    @include('components.footer')
</div>

{{-- Script --}}
<script>
    const scrollWrapper = document.getElementById('categoryScrollWrapper');
    const scrollLeftBtn = document.getElementById('scrollLeft');
    const scrollRightBtn = document.getElementById('scrollRight');

    scrollLeftBtn.addEventListener('click', () => {
        scrollWrapper.scrollBy({ left: -300, behavior: 'smooth' });
    });

    scrollRightBtn.addEventListener('click', () => {
        scrollWrapper.scrollBy({ left: 300, behavior: 'smooth' });
    });
</script>
@endsection
