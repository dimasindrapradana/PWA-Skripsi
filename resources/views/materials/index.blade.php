@extends('layouts.app')

@section('title', 'Daftar Materi')

@section('content')
@include('components.navbar')
@include('components.mobile-navbar')

<div class="max-w-5xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-extrabold text-slate-900 mb-7 text-center">Daftar Materi Fotografi</h1>

    {{-- Search box --}}
    <form method="GET" action="{{ route('materials.index') }}" class="mb-7">
        <div class="relative mb-7">
            <input type="text" name="search" id="search-input" autocomplete="off" value="{{ $search ?? '' }}"
                class="w-full px-4 py-3 border-2 border-indigo-200 rounded-xl shadow-sm focus:ring-indigo-600 focus:border-indigo-600 bg-white text-slate-900"
                placeholder="Cari judul materi...">
            <div id="autocomplete-list"
                class="absolute z-50 left-0 right-0 mt-2 bg-slate-900 text-white rounded-xl shadow-lg hidden"></div>
        </div>
    </form>

    @foreach($categories as $category)
        <div class="mb-14">
            <div class="flex flex-col sm:flex-row items-center gap-3 mb-4">
                <div class="mb-4">
                    <h2 class="text-xl sm:text-2xl font-bold text-indigo-700 mb-2">{{ $category->name }}</h2>
                    <div class="prose max-w-none text-slate-600 text-sm">
                        {!! $category->description !!}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($category->materials as $material)
                    <div class="bg-white border border-indigo-100 rounded-2xl shadow-lg p-7 flex flex-col justify-between hover:scale-[1.025] hover:shadow-indigo-200 transition-all duration-150">
                        <div>
                            <h3 class="text-lg font-bold text-indigo-800 mb-2">{{ $material->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ \Illuminate\Support\Str::limit(strip_tags($material->content), 110) }}
                            </p>
                        </div>
                        <a href="{{ route('materi.show', $material->slug) }}"
                           class="mt-4 block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg shadow transition">
                            Buka Materi
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <script>
    const input = document.getElementById('search-input');
    const list = document.getElementById('autocomplete-list');

    input.addEventListener('input', function () {
        const query = this.value.trim();
        if (query.length < 2) {
            list.classList.add('hidden');
            list.innerHTML = '';
            return;
        }
        fetch('{{ route('materials.autocomplete') }}?q=' + encodeURIComponent(query))
            .then(res => res.json())
            .then(data => {
                if (input.value.trim() !== query) return;
                list.innerHTML = '';
                if (data.length) {
                    data.forEach(result => {
                        const item = document.createElement('div');
                        item.className = 'px-4 py-2 cursor-pointer hover:bg-indigo-700 rounded-xl flex items-center gap-2';
                        if(result.type === 'kategori') {
                            item.innerHTML = `<span class="inline-block w-2 h-2 bg-indigo-500 rounded-full"></span>`;
                        } else {
                            item.innerHTML = `<span class="inline-block w-2 h-2 bg-slate-600 rounded-full"></span>`;
                        }
                        item.innerHTML += `<span>${result.label}</span> <span class="ml-2 px-2 py-0.5 text-xs rounded ${result.type === 'kategori' ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-200 text-slate-700'}">${result.type}</span>`;
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
    @include("components.footer")
</div>
@endsection
