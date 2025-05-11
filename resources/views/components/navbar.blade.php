<nav class="bg-gray-800 text-white px-4 py-3 flex items-center justify-between">
    <!-- Logo -->
    <div class="flex items-center">
        <span class="text-lg font-bold">LOGO</span>
    </div>
    <!-- Bagian kanan: search + avatar -->
    <div class="header-actions">
         <form id="materialSearchForm" class="header-search-form" autocomplete="off">
            <input type="text" class="header-search-input hidden" placeholder="Cari materi..." />
        </form>
        <button type="button" class="header-search" id="searchToggle" title="Cari">
            <!-- Search Icon SVG -->
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="7"/>
                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
        </button>
        <div class="avatar-initial ml-2 flex items-center justify-center w-8 h-8 rounded-full bg-blue-500 text-white font-bold border-2 border-white">
            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
        </div>
    </div>
</nav>
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
