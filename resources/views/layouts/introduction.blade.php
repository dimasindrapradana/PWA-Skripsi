<!-- filepath: resources/views/layouts/introduction.blade.php -->
@extends('layouts.app')

@section('title', 'Pengantar Materi')

@section('content')
<div class="min-h-screen flex flex-col bg-gradient-edu">
     @include('components.navbar')
    <main class="flex-grow flex flex-col items-center justify-center p-4">
       <div class="intro-card">
    <h1>Pembelajaran “nama kategori“</h1>
    <p>Pelajari Materi SOP, Peralatan dan Variabel Pemotretan untuk meningkatkan babalblablablab</p>
    <a href="/materi" class="intro-start-btn">Mulai Belajar</a>
    <h2>Yang akan anda dapatkan</h2>
            <div class="benefit-grid">
                <div class="benefit-card">
                <h3>Modul</h3>
                <p>Materi bacaan elektronik disajikan dengan bahasa yang mudah dipahami</p>
                </div>
                 <div class="benefit-card">
                <h3>Video</h3>
                <p>Materi Video disajikan dengan durasi singkat agar nyaman ditonton</p>
                 </div>
                 <div class="benefit-card">
                 <h3>Quis</h3>
                 <p>Kuis pilihan ganda membantu anda memahami materi yang dipelajari</p>
                 </div>
            </div>
        </div>
</main>
</div>
@endsection