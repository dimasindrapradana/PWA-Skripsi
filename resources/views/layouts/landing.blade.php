@extends('layouts.app')

@section('title', 'Ruang Fotografi')

@section('content')
<!-- AOS animation -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>


<div class="min-h-screen bg-gradient-to-br from-indigo-900 via-slate-900 to-black flex items-center px-6 sm:px-12 py-12 text-white">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center w-full">

        <!-- Teks -->
        <div data-aos="fade-right" data-aos-delay="100">
            <h1 class="text-3xl sm:text-4xl font-extrabold leading-tight mb-4">
                Belajar Fotografi Jadi <span class="text-indigo-400">Lebih Mudah</span> & <span class="text-indigo-300">Menyenangkan</span>
            </h1>
            <p class="text-slate-300 text-base sm:text-lg leading-relaxed mb-6">
                Platform pembelajaran <strong>Fotografi Dasar</strong> untuk siswa SMK. Belajar teori, praktik, dan kuis secara interaktif, langsung dari perangkatmu.
            </p>
            <a href="{{ route('login.user') }}"
               class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow transition text-base">
                Masuk ke Platform
                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            <p class="mt-3 text-sm text-slate-400">Login berlaku untuk semua peran (siswa & admin)</p>
        </div>

        <!-- Animasi atau Gambar -->
        <div class="flex justify-center" data-aos="fade-left" data-aos-delay="200">
            <lottie-player
                src="https://assets4.lottiefiles.com/packages/lf20_rqrrig2u.json"
                background="transparent"
                speed="1"
                loop
                autoplay
                class="w-64 h-64 sm:w-80 sm:h-80">
            </lottie-player>
        </div>
    </div>
</div>
@endsection
