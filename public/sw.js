self.addEventListener('push', function(event) {
    console.log('[Service Worker] Push Received.');
    console.log('[Service Worker] Push had this data: "${event.data.text()}"');

    const title = 'Dogcat';
    const options = {
        body: 'Nueva cita asignada.s.s',
        icon: 'imagenes/sistema/dogcat.png',
        badge: 'imagenes/labrador.jpg'
    };

    event.waitUntil(self.registration.showNotification(title, options));
});

self.addEventListener('notificationclick', function(event) {
    console.log('[Service Worker] Notification click Received.');

    event.notification.close();

    event.waitUntil(
        clients.openWindow('https://developers.google.com/web/')
    );
});