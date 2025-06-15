const CACHE_NAME = 'pwa-laravel-cache-v1';
const urlsToCache = [
  '/',
  '/manifest.json',
  '/build/assets/app-0Qchtg2p.css',
  '/build/assets/app-T1DpEqax.js',
  '/images/Logo rfskagata.png',
];

// Install Service Worker dan cache asset penting
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => {
      return cache.addAll(urlsToCache);
    })
  );
});

// Hapus cache lama saat SW baru aktif
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames
          .filter(name => name !== CACHE_NAME)
          .map(name => caches.delete(name))
      );
    })
  );
});

// Intersep request dan gunakan cache jika tersedia
self.addEventListener('fetch', event => {
  // Lewatkan request dari luar origin (misal Google Fonts)
  if (!event.request.url.startsWith(self.location.origin)) return;

  event.respondWith(
    caches.match(event.request).then(response => {
      return (
        response ||
        fetch(event.request).catch(() =>
          // Fallback halaman jika offline dan tidak ada cache
          caches.match('/')
        )
      );
    })
  );
});
