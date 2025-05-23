// Service Worker (vide, mais nécessaire pour les notifications)
self.addEventListener('notificationclick', function(event) {
  event.notification.close();
  event.waitUntil(
    clients.openWindow('/') // Ouvre la page d'accueil si on clique
  );
});
