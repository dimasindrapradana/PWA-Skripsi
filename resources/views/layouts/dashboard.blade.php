<!-- filepath: resources/views/layouts/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="min-h-screen flex flex-col bg-gradient-edu">
    @include('components.navbar')

    <main class="flex-grow p-4 sm:p-6">
        <h1 class="text-xl sm:text-2xl font-bold mb-4 text-white drop-shadow">Selamat Datang, Siswa!</h1>
        <p class="mb-6 text-base sm:text-lg text-white drop-shadow">Pilih kategori materi untuk memulai pembelajaran fotografi.</p>

        <div class="category-list">
            <section class="category-card">
                <h2 class="category-title">Pra Produksi</h2>
                <p class="category-desc">Belajar persiapan sebelum produksi.</p>
                <a href="/kategori/pra-produksi" class="category-btn">Lihat Materi</a>
            </section>
            <section class="category-card">
                <h2 class="category-title">Produksi</h2>
                <p class="category-desc">Belajar proses produksi fotografi.</p>
                <a href="/kategori/produksi" class="category-btn">Lihat Materi</a>
            </section>
            <section class="category-card">
                <h2 class="category-title">Pasca Produksi</h2>
                <p class="category-desc">Belajar editing dan finishing.</p>
                <a href="/kategori/pasca-produksi" class="category-btn">Lihat Materi</a>
            </section>
        </div>
    </main>


</div>
@include('components.footer')
@endsection