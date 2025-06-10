<nav class="sticky top-0 z-30 w-full bg-white/90 border-b border-slate-200 shadow-sm flex items-center justify-between px-4 py-3">
    <a href="{{ route('kategori.show', $material->category->slug) }}"
       class="mr-3 flex items-center justify-center w-9 h-9 rounded hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-300 transition"
       aria-label="Kembali ke Kategori">
        <!-- Icon panah kiri -->
        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        <span class="ml-1 text-sm font-medium text-gray-700 hidden sm:inline">Kembali</span>
    </a>
    <!-- Judul Materi -->
    <h1 class="flex-1 text-lg font-bold text-slate-800 text-center truncate px-2">
        {{ $material->title }}
    </h1>
    <!-- Tombol Sidebar (sekarang di kanan) -->
    <button id="sidebarToggle" type="button"
        class="ml-3 flex items-center justify-center w-9 h-9 rounded hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-300 transition"
        aria-label="Buka navigasi materi">
        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
</nav>
