@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
@include('components.navbar')
@include('components.mobile-navbar')

<div class="min-h-screen flex flex-col bg-gray-50 ">
    <main class="flex-grow px-4 sm:px-6 py-8 max-w-7xl mx-auto space-y-10 pb-16">

        {{-- Sapaan Personal --}}
        <div class="flex flex-col items-center text-center mb-2">
            <h1 class="text-3xl font-extrabold text-slate-900 mb-2">Halo, {{ auth()->user()->name }}! 👋</h1>
            <p class="text-base text-slate-700 mb-1">Ayo lanjutkan perjalanan fotografimu hari ini.</p>
            <p class="text-sm text-indigo-500 italic">"Belajar adalah jendela dunia. Setiap klik kamera adalah ilmu baru!"</p>
        </div>
        {{-- Promo Install PWA --}}
        <div id="pwa-install-banner"
            class="hidden bg-indigo-50 border border-indigo-200 rounded-2xl p-6 sm:p-8 shadow-md text-center transition"
            data-aos="fade-down">
            <h2 class="text-2xl font-extrabold text-indigo-800 mb-2">📱 Pasang Aplikasi Ini!</h2>
            <p class="text-slate-700 text-sm mb-4">
                Ingin belajar lebih nyaman? Pasang aplikasi Ruang Fotografi langsung di layar utama perangkatmu.
            </p>
            <button id="installBtn"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition">
                Pasang Sekarang
            </button>
            <p class="text-xs text-slate-500 mt-3">
                Pengguna iPhone: Buka di Safari, lalu pilih <strong>Share → Add to Home Screen</strong>
            </p>
        </div>

        {{-- Daftar Kategori Materi --}}
        <div>
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Kategori Yang Tersedia</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach ($categories as $category)
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 flex flex-col justify-between hover:shadow-lg transition relative">
                        {{-- Icon kategori, jika punya --}}
                        <div class="flex items-center gap-2 mb-3">
                            <h3 class="text-lg font-bold text-indigo-700">{{ $category->name }}</h3>
                        </div>
                        <p class="text-gray-600 text-sm flex-grow">{{ \Illuminate\Support\Str::limit(strip_tags($category->description), 150) }}</p>
                        <a href="{{ route('kategori.show', $category->slug) }}"
                           class="mt-4 block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg shadow transition">
                            Lihat Materi
                        </a>
                        {{-- Label Baru (optional) --}}
                        @if($category->is_new ?? false)
                            <span class="absolute top-2 right-3 bg-yellow-400 text-indigo-900 text-xs px-2 py-0.5 rounded-full font-semibold shadow">Baru!</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Tombol Kuis --}}
        <div class="flex flex-col items-center mt-10">
            <div class="text-center mb-3">
                <p class="text-lg font-semibold text-slate-800 mb-1">Siap menguji kemampuanmu?</p>
                <p class="text-sm text-slate-500">Kerjakan kuis dan dapatkan nilai terbaikmu!</p>
            </div>
            <a href="{{ route('quiz.index') }}"
                class="bg-yellow-400 hover:bg-yellow-500 text-indigo-900 font-bold px-8 py-3 rounded-xl shadow-lg text-lg transition">
                🎯 Kerjakan Kuis Sekarang
            </a>
        </div>
        
        {{-- Motivasi --}}
        <div class="mt-8 text-center text-sm text-indigo-600 font-medium italic">
            "Practice makes perfect! Jangan ragu untuk belajar dan mencoba kuis berkali-kali."
        </div>
        <script>
            let deferredPrompt;
            const installBtn = document.getElementById('installBtn');
            const banner = document.getElementById('pwa-install-banner');

            // Simpan event jika memenuhi syarat
            window.addEventListener('beforeinstallprompt', (e) => {
                e.preventDefault();
                deferredPrompt = e;
                banner.style.display = 'block';
            });

            // Klik tombol install
            installBtn?.addEventListener('click', async () => {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    const result = await deferredPrompt.userChoice;
                    if (result.outcome === 'accepted') {
                        banner.style.display = 'none';
                    }
                    deferredPrompt = null;
                }
            });
        </script>

  </main>
</div>
@include('components.footer')
@endsection
