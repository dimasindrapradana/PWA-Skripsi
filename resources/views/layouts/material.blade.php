<!-- filepath: resources/views/layouts/materi.blade.php -->
@extends('layouts.app')

@section('title', 'Materi Fotografi')

@section('content')
<div class="material-page">
      @include('components.material-navbar')
   
    <div class="material-body">
        <main class="material-main">
            <h1 class="material-title">Pengenalan Pra Produksi</h1>
            <div class="material-video">Video</div>
            <h2 class="material-subtitle">Sub Judul</h2>
            <p class="material-desc">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...
            </p>
            <div class="material-nav-bottom">
                <a href="#" class="nav-back">Back</a>
                <a href="#" class="nav-next">Next</a>
            </div>
        </main>
        <aside class="material-sidebar-popup hidden" id="materialSidebar">
        <div class="sidebar-popup-overlay" id="sidebarOverlay"></div>
        <div class="sidebar-popup-content">
            <div class="sidebar-title">Modul</div>
            <div class="sidebar-section">
                <div class="sidebar-section-title">Materi</div>
                <ul class="sidebar-list">
                    <li class="sidebar-item active"><span class="sidebar-icon">&#9679;</span> Sub Materi</li>
                    <li class="sidebar-item"><span class="sidebar-icon">&#9675;</span> Sub Materi</li>
                    <li class="sidebar-item"><span class="sidebar-icon">&#9675;</span> Sub Materi</li>
                </ul>
            </div>
            <div class="sidebar-section">
                <div class="sidebar-section-title">Materi</div>
                <ul class="sidebar-list">
                    <li class="sidebar-item"><span class="sidebar-icon">&#9675;</span> Sub Materi</li>
                    <li class="sidebar-item"><span class="sidebar-icon">&#9675;</span> Sub Materi</li>
                </ul>
            </div>
        </div>
    </aside>
    
</div>
<script>
document.getElementById('sidebarToggle').onclick = function() {
    document.getElementById('materialSidebar').classList.toggle('hidden');
};
document.getElementById('sidebarOverlay').onclick = function() {
    document.getElementById('materialSidebar').classList.add('hidden');
};
</script>

@endsection