const CACHE_NAME = 'pwa-laravel-cache-v1';
const urlsToCache = [
  '/',
  '/manifest.json',
  '/build/assets/app-0Qchtg2p.css',
  '/build/assets/app-T1DpEqax.js',
  '/images/Logo rfskagata.png',
];

// Precache saat install
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => cache.addAll(urlsToCache))
  );
});

// Bersihkan cache lama saat activate
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(keys =>
      Promise.all(keys
        .filter(key => key !== CACHE_NAME)
        .map(key => caches.delete(key))
      )
    )
  );
});

// Intersep semua GET request
self.addEventListener('fetch', event => {
  if (event.request.method !== 'GET') return;

  const requestURL = new URL(event.request.url);

  // Lewati request ke luar origin
  if (requestURL.origin !== location.origin) return;

  // Gunakan cache dulu, jika gagal fetch, lalu fallback
  event.respondWith(
    fetch(event.request)
      .then(networkResponse => {
        // Simpan ke cache untuk nanti
        return caches.open(CACHE_NAME).then(cache => {
          cache.put(event.request, networkResponse.clone());
          return networkResponse;
        });
      })
      .catch(() =>
        caches.match(event.request).then(response => {
          return response || caches.match('/offline');
        })
      )
  );
});