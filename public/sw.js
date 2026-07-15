self.addEventListener('push', function(event) {
    if (!event.data) {
        return;
    }

    try {
        const payload = event.data.json();

        const title = payload.title || 'Pengingat TBC Care';
        const options = {
            body: payload.body || 'Jangan lupa minum obat hari ini!',
            icon: payload.icon || '/favicon.ico',
            data: {
                url: payload.url || '/'
            },
            vibrate: [200, 100, 200]
        };

        event.waitUntil(
            self.registration.showNotification(title, options)
        );
    } catch (e) {
        console.error('Error parsing push data:', e);
    }
});

self.addEventListener('notificationclick', function(event) {
    event.notification.close();

    const targetUrl = event.notification.data ? event.notification.data.url : '/';

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function(clientList) {
            for (let i = 0; i < clientList.length; i++) {
                let client = clientList[i];
                if (client.url === targetUrl && 'focus' in client) {
                    return client.focus();
                }
            }
            if (clients.openWindow) {
                return clients.openWindow(targetUrl);
            }
        })
    );
});
