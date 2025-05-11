<!-- filepath: resources/views/layouts/category.blade.php -->
@extends('layouts.app')

@section('title', 'Kategori Materi')

@section('content')
<div class="min-h-screen flex flex-col bg-gradient-edu">
    @include('components.navbar')

    <main class="flex-grow p-4 sm:p-6">
        <h1 class="text-xl sm:text-2xl font-bold mb-4">Kategori Materi</h1>
        <p class="mb-6 text-base sm:text-lg">Pilih kategori untuk memulai pembelajaran fotografi.</p>

        <!-- Kategori: Vertikal, mirip Dicoding/Coursera -->
        <div class="category-list">
            <section class="category-card">
                <h2 class="category-title">Pra Produksi</h2>
                <p class="category-desc">Lorem ipsum dolor sit amet, belajar persiapan sebelum produksi fotografi.</p>
                <a href="/kategori/pra-produksi" class="category-btn">Lihat Materi</a>
            </section>
            <section class="category-card">
                <h2 class="category-title">Produksi</h2>
                <p class="category-desc">Lorem ipsum dolor sit amet, belajar proses produksi fotografi.</p>
                <a href="/kategori/produksi" class="category-btn">Lihat Materi</a>
            </section>
            <section class="category-card">
                <h2 class="category-title">Pasca Produksi</h2>
                <p class="category-desc">Lorem ipsum dolor sit amet, belajar editing dan finishing fotografi.</p>
                <a href="/kategori/pasca-produksi" class="category-btn">Lihat Materi</a>
            </section>
        </div>
    </main>

</div>
@include('components.footer')
@endsection