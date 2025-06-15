<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>@yield('title')</title>

  {{-- Vite akan inject CSS/JS hashed --}}
  @vite([
    'resources/css/app.css',
    'resources/js/app.js',
  ])
  @filamentStyles {{-- jika memakai Filament --}}

  {{-- PWA manifest & icons --}}
  <link rel="manifest" href="{{ asset('manifest.json') }}">
  <meta name="theme-color" content="#0d6efd">
  <link rel="apple-touch-icon" href="{{ asset('icons/icon-192x192.png') }}">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="default">
  <meta name="apple-mobile-web-app-title" content="PWA Fotografi">
</head>
<body>

  @yield('content')

  @filamentScripts {{-- jika memakai Filament --}}
</body>
</html>
