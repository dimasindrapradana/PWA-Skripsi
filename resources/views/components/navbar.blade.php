<nav class="sticky top-0 z-40 w-full bg-white shadow-lg py-3 px-4 sm:px-8 items-center justify-between hidden md:flex">
    {{-- Logo --}}
    <div class="flex items-center gap-3">
        <img src="{{ asset('images/Logo rfskagata.png') }}" alt="Logo" class="h-10 w-auto">
        <span class="text-gray-900 font-bold text-lg tracking-tight">RF SKAGATA</span>
        <div class="flex gap-1 ml-8">
            <a href="{{ route('user.dashboard') }}" class="px-4 py-2 rounded font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition">Beranda</a>
            <a href="{{ route('quiz.index') }}" class="px-4 py-2 rounded font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition">Daftar Kuis</a>
            <a href="{{ route('materials.index') }}" class="px-4 py-2 rounded font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition">Daftar Materi</a>
        </div>
    </div>
    {{-- Logout --}}
    <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Apakah Anda yakin ingin logout?')">
        @csrf
        <button type="submit" class="px-4 py-2 rounded border border-slate-300 text-gray-700 hover:bg-slate-100 hover:text-red-500 font-semibold transition">
            Logout
        </button>
    </form>
</nav>
