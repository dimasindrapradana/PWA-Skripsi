
@extends('layouts.app')

@section('title', 'Landing Page')

@section('content')
<body class="bg-indigo-200 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-gray-800 text-white px-4 py-3 flex justify-between items-center">
        <button class="bg-gray-600 px-4 py-1 rounded text-sm">LOGO</button>
        <button class="bg-gray-600 px-4 py-1 rounded text-sm">SIGN IN</button>
    </nav>

    <!-- Hero Section -->
    <main class="flex-grow flex flex-col justify-center items-center bg-gray-700 text-white text-center px-4">
        <div class="bg-gray-300 text-black w-full max-w-xl h-64 flex items-center justify-center mb-6">
            <span class="text-lg font-medium">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span>
        </div>
        <button class="bg-white text-black font-semibold px-6 py-2 rounded-full shadow hover:bg-gray-200 transition">
            GET STARTED
        </button>
    </main>

</body>
@endsection