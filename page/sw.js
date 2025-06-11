// sw.js
self.addEventListener('push', function(event) {
  const data = event.data ? event.data.json() : {};
  const title = data.title || "Tâche urgente !";
  const options = {
    body: data.body || "Vous avez une tâche proche de la date limite.",
    icon: '/icon.png',
    badge: '/icon.png'
  };
  event.waitUntil(
    self.registration.showNotification(title, options)
  );
});
