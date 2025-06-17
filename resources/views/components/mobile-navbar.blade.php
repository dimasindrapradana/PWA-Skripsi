@php
    $currentRoute = request()->route()->getName();
@endphp
<nav class="fixed bottom-0 left-0 w-full z-40 bg-white border-t border-gray-200 shadow-lg flex justify-around items-center py-1 px-1 md:hidden">
    <a href="{{ route('user.dashboard') }}"
       class="flex flex-col items-center flex-1 transition-all duration-200
        {{ $currentRoute == 'user.dashboard' ? 'text-indigo-600' : 'text-slate-600' }}
        hover:text-indigo-700 hover:scale-110">
        <svg class="w-6 h-6 mb-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h3a1 1 0 001-1v-5h2v5a1 1 0 001 1h3a1 1 0 001-1V10" />
        </svg>
        <span class="text-[11px] leading-none text-center w-full">Beranda</span>
    </a>
    <a href="{{ route('quiz.index') }}"
       class="flex flex-col items-center flex-1 transition-all duration-200
        {{ $currentRoute == 'quiz.index' ? 'text-indigo-600' : 'text-slate-600' }}
        hover:text-indigo-700 hover:scale-110">
        <svg class="w-6 h-6 mb-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="text-[11px] leading-none text-center w-full">Kuis</span>
    </a>
    <a href="{{ route('materials.index') }}"
       class="flex flex-col items-center flex-1 transition-all duration-200
        {{ $currentRoute == 'materials.index' ? 'text-indigo-600' : 'text-slate-600' }}
        hover:text-indigo-700 hover:scale-110">
        <svg class="w-6 h-6 mb-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <rect x="4" y="6" width="16" height="12" rx="2" />
            <path d="M4 10h16" />
        </svg>
        <span class="text-[11px] leading-none text-center w-full">Materi</span>
    </a>
    <form method="POST" action="{{ route('logout') }}" class="flex flex-col items-center flex-1"onsubmit="return confirm('Yakin ingin keluar dari akun?')">
        @csrf
        <button type="submit"
           class="flex flex-col items-center text-slate-600 hover:text-red-500 hover:scale-110 transition-all duration-200">
            <svg class="w-6 h-6 mb-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1"/>
            </svg>
            <span class="text-[11px] leading-none text-center w-full">Logout</span>
        </button>
    </form>
</nav>
