<!-- filepath: resources/views/components/material-navbar.blade.php -->
<nav class="material-header">
    <a href="{{ route('kategori.show', $material->category->slug) }}" class="header-back" title="Kembali">&lt;</a>
    <div class="header-actions">
        <form id="materialSearchForm" class="relative" autocomplete="off">
            <input type="text" id="searchInput"
                class="hidden sm:block border border-gray-300 rounded-md px-3 py-1 text-sm text-gray-700 focus:outline-none focus:ring focus:ring-blue-300"
                placeholder="Cari materi...">
        </form>
        <button type="button" class="header-search" id="searchToggle" title="Cari">
            <!-- Search Icon SVG -->
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="7"/>
                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
        </button>
        <button class="header-nav" id="sidebarToggle" title="Tampilkan/Sembunyikan Daftar Materi">
            <!-- List/Menu Icon SVG -->
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="4" y="5" width="16" height="2" rx="1"/>
                <rect x="4" y="11" width="16" height="2" rx="1"/>
                <rect x="4" y="17" width="16" height="2" rx="1"/>
            </svg>
        </button>
    </div>
    <script>
const searchToggle = document.getElementById('searchToggle');
const searchInput = document.querySelector('.header-search-input');
const searchForm = document.getElementById('materialSearchForm');

searchToggle.onclick = function(e) {
    e.preventDefault();
    searchInput.classList.toggle('show');
    searchInput.classList.toggle('hidden');
    if (searchInput.classList.contains('show')) {
        searchInput.focus();
    } else {
        searchInput.value = '';
    }
};

searchForm.onsubmit = function(e) {
    e.preventDefault();
    alert('Cari: ' + searchInput.value);
    searchInput.classList.remove('show');
    searchInput.classList.add('hidden');
};
</script>
</nav>