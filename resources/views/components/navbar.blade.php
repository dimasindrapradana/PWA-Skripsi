<nav class="bg-white border-b border-gray-200 px-4 py-3 shadow-sm flex items-center justify-between">
    <!-- Logo -->
    <div class="flex items-center space-x-3">
        <span class="text-xl font-semibold text-gray-800">📸 FOTOGRAFI</span>
    </div>

    <!-- Search + Avatar -->
    <div class="flex items-center space-x-2">
        <!-- Search group -->
        <div class="header-actions">
            <input type="text" id="searchInput"
                class="hidden search-input border border-gray-300 rounded-md px-3 py-1 text-sm text-gray-700 focus:outline-none focus:ring focus:ring-blue-300"
                placeholder="Cari materi...">

            <button type="button" id="searchToggle" title="Cari" class="text-gray-600 hover:text-gray-800">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="7"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </button>
        </div>

        <!-- Avatar -->
          <div class="avatar-initial ml-2 flex items-center justify-center w-8 h-8 rounded-full bg-blue-500 text-white font-bold border-2 border-white">
            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
        </div>
    </div>
    </div>
</nav>
