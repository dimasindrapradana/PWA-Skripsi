<nav class="sticky top-0 z-40 w-full bg-white shadow-lg py-3 px-4 sm:px-8 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <img src="/logo.svg" class="h-8 w-8" alt="Logo">
        <span class="text-gray-900 font-bold text-lg tracking-tight">PWA Fotografi</span>
        <a href="{{ route('user.dashboard') }}"
           class="ml-2 px-3 py-1 rounded font-medium text-gray-700 hover:bg-slate-100 hover:text-blue-600 transition focus:outline-none focus:ring-2 focus:ring-blue-300">
            Beranda
        </a>
        <!-- LINK BARU UNTUK DAFTAR KUIS -->
        <a href="{{ route('quiz.list') }}"
           class="ml-2 px-3 py-1 rounded font-medium text-gray-700 hover:bg-slate-100 hover:text-yellow-600 transition focus:outline-none focus:ring-2 focus:ring-yellow-300">
            Daftar Kuis
        </a>
    </div>
    <div class="flex items-center gap-6">
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit"
                class="px-4 py-1.5 rounded border border-slate-300 text-gray-700 hover:bg-slate-100 hover:text-red-500 font-semibold transition focus:outline-none focus:ring-2 focus:ring-red-200">
                Logout
            </button>
        </form>
    </div>
</nav>
