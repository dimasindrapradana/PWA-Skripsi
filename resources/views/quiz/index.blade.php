@extends('layouts.app')
@section('title', 'Daftar Kuis')

@section('content')
@include('components.navbar')
@include('components.mobile-navbar')

<div class="max-w-5xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-extrabold text-slate-900 mb-7 text-center">Daftar Kuis</h1>

    {{-- Search box --}}
    <form method="GET" action="{{ route('quiz.index') }}" class="mb-7">
        <div class="relative mb-7">
            <input type="text" name="q" id="search-input" autocomplete="off" value="{{ request('q') }}"
                class="w-full px-4 py-3 border-2 border-indigo-200 rounded-xl shadow-sm focus:ring-indigo-600 focus:border-indigo-600 bg-white text-slate-900"
                placeholder="Cari judul kuis atau materi...">
            <div id="autocomplete-list"
                class="absolute z-50 left-0 right-0 mt-2 bg-slate-900 text-white rounded-xl shadow-lg hidden"></div>
        </div>
    </form>

    @forelse($categories as $category)
        @php $categoryTests = $tests->where('material.category_id', $category->id); @endphp
        @if($categoryTests->count())
        <div class="mb-14">
            <div class="flex flex-col sm:flex-row items-center gap-3 mb-4">
                <h2 class="text-xl sm:text-2xl font-bold text-indigo-700 flex-shrink-0">{{ $category->name }}</h2>
                <span class="h-2 w-32 bg-indigo-200 rounded-full sm:ml-2"></span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($categoryTests as $test)
                    @php
                        $result = $userResults[$test->id] ?? null;
                        $isPassed = $result && $result->score >= 70;
                    @endphp
                    <div class="bg-white border border-indigo-100 rounded-2xl shadow-lg p-7 flex flex-col justify-between hover:scale-[1.025] hover:shadow-indigo-200 transition-all duration-150 relative">
                        {{-- Status Badge --}}
                        <div class="absolute top-4 right-4">
                            @if($isPassed)
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded text-xs font-semibold">Lulus</span>
                            @elseif($result)
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded text-xs font-semibold">Belum Lulus</span>
                            @else
                                <span class="bg-slate-100 text-slate-500 px-3 py-1 rounded text-xs">Belum Dikerjakan</span>
                            @endif
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-slate-900 mb-1">{{ $test->title }}</h2>
                            <p class="text-sm text-indigo-700 mb-2 font-semibold">Materi: {{ $test->material->title ?? '-' }}</p>
                        </div>
                        <div class="mt-3 flex flex-wrap gap-2">
                            @if(in_array($test->material_id, $readMaterialIds))
                                <a href="{{ route('quiz.show', $test->slug) }}"
                                class="bg-yellow-400 hover:bg-yellow-500 text-indigo-900 font-bold px-5 py-2 rounded-lg shadow transition text-sm">
                                {{ $isPassed ? 'Kerjakan Ulang' : 'Kerjakan' }}
                                </a>
                            @else
                                <button onclick="alert('Silakan baca materi terlebih dahulu sebelum mengerjakan kuis.')"
                                    class="bg-slate-200 text-slate-500 font-bold px-5 py-2 rounded-lg shadow text-sm cursor-not-allowed">
                                    {{ $isPassed ? 'Kerjakan Ulang' : 'Kerjakan' }}
                                </button>
                            @endif
                            @if($result)
                                <a href="{{ route('quiz.result', $result->slug) }}"
                                    class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 px-5 py-2 rounded-lg font-semibold shadow transition text-sm">
                                    Lihat Hasil
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    @empty
        <div class="text-center text-gray-500 py-12">Belum ada kategori/kuis.</div>
    @endforelse

    <script>
    // Autocomplete search quiz
    const input = document.getElementById('search-input');
    const list = document.getElementById('autocomplete-list');

    input.addEventListener('input', function () {
        const query = this.value.trim();
        if (query.length < 2) {
            list.classList.add('hidden');
            list.innerHTML = '';
            return;
        }
        fetch('{{ route('quiz.autocomplete') }}?q=' + encodeURIComponent(query))
            .then(res => res.json())
            .then(data => {
                if (input.value.trim() !== query) return;
                list.innerHTML = '';
                if (data.length) {
                    data.forEach(result => {
                        const item = document.createElement('div');
                        item.className = 'px-4 py-2 cursor-pointer hover:bg-indigo-700 rounded-xl flex items-center gap-2';
                        // Icon untuk kategori/kuis
                        if(result.type === 'kategori') {
                            item.innerHTML = `<span class="inline-block w-2 h-2 bg-indigo-500 rounded-full"></span>`;
                        } else {
                            item.innerHTML = `<span class="inline-block w-2 h-2 bg-yellow-400 rounded-full"></span>`;
                        }
                        item.innerHTML += `<span>${result.label}</span> <span class="ml-2 px-2 py-0.5 text-xs rounded ${result.type === 'kategori' ? 'bg-indigo-100 text-indigo-700' : 'bg-yellow-100 text-yellow-700'}">${result.type}</span>`;
                        item.onclick = function() {
                            input.value = result.label;
                            list.classList.add('hidden');
                            input.form.submit();
                        };
                        list.appendChild(item);
                    });
                    list.classList.remove('hidden');
                } else {
                    list.classList.add('hidden');
                }
            });
    });

    document.addEventListener('click', function(e){
        if (!input.contains(e.target) && !list.contains(e.target)) {
            list.classList.add('hidden');
        }
    });
    </script>

    @include('components.footer')
</div>
@endsection
