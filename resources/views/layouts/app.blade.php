
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/build/assets/app-YmFXhLMK.css">

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- manifest -->
<link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="#0d6efd">

<!-- iOS support -->
<link rel="apple-touch-icon" href="/icons/icon-192x192.png">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="PWA Laravel">

<!-- Service worker registration -->
<script>
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', function () {
      navigator.serviceWorker.register('/service-worker.js')
        .then(function (registration) {
          // Registration successful
          // console.log('ServiceWorker registration successful with scope: ', registration.scope);
        }, function (err) {
          // Registration failed
          // console.log('ServiceWorker registration failed: ', err);
        });
    });
  }
</script>

</head>
<body>
    @yield('content')
</body>
</html>