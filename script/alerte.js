// Enregistre le service worker une seule fois
if ('Notification' in window && navigator.serviceWorker) {
    navigator.serviceWorker.register('service-worker.js').then(() => {
        console.log('Service Worker OK');
    });
    Notification.requestPermission();
}

function showNotification(titre, message) {
    if (Notification.permission === 'granted') {
        navigator.serviceWorker.ready.then(reg => {
            reg.showNotification(titre, {
                body: message,
                icon: 'https://cdn-icons-png.flaticon.com/512/565/565547.png',
                tag: 'rappel-tache'
            });
        });
    }
}

// Notifications PHP injectées ici
// Assurez-vous que la variable "rappels" est définie dans votre page HTML/PHP avant d'inclure ce JS
if (typeof rappels !== "undefined" && Array.isArray(rappels)) {
    rappels.forEach(msg => {
        setTimeout(() => {
            showNotification("⏰ Rappel", "Tache non effectuée: " + msg);
        }, 3000); // petit délai pour éviter les conflits de chargement
    });
}
