@extends('layouts.app')
@section('title', 'Daftar Kuis')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Daftar Kuis</h1>
    <div class="bg-white shadow rounded-xl p-6">
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="px-3 py-2 text-left">Judul Kuis</th>
                    <th class="px-3 py-2 text-left">Materi</th>
                    <th class="px-3 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($tests as $test)
                <tr class="border-b">
                    <td class="px-3 py-2 font-semibold">{{ $test->title }}</td>
                    <td class="px-3 py-2">{{ $test->material->title ?? '-' }}</td>
                    <td class="px-3 py-2">
                        <a href="{{ route('quiz.show', $test->slug) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow">Kerjakan</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
