@extends('layouts.app')
@section('title', 'Koneksi Terputus')

@section('content')
@include('components.navbar')
@include('components.mobile-navbar')

<div class="min-h-screen flex flex-col items-center justify-center text-center px-6 py-20 bg-gradient-to-br from-slate-100 to-white">

    <h1 class="text-2xl sm:text-3xl font-extrabold text-indigo-700 mb-3">
        Kamu Sedang Offline
    </h1>
    <p class="text-slate-600 text-sm sm:text-base max-w-md">
        Beberapa fitur atau halaman tidak bisa dibuka tanpa koneksi internet. 
        Silakan sambungkan kembali untuk melanjutkan pembelajaran.
    </p>


</div>

@include('components.footer')
@endsection
