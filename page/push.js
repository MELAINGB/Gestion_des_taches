// Enregistrement du Service Worker
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('sw.js')
    .then(() => console.log('✅ Service Worker enregistré'))
    .catch(e => console.error('❌ SW error:', e));
}

// Demande de permission pour les notifications
if (Notification.permission !== 'granted') {
  Notification.requestPermission();
}

// === LocalStorage : Rappels déjà envoyés ===
function getNotifiedTaskIds() {
  return JSON.parse(localStorage.getItem('notifiedTasks')) || [];
}

function saveNotifiedTaskId(id_tache, type) {
  const ids = getNotifiedTaskIds();
  const key = `${id_tache}_${type}`;
  if (!ids.includes(key)) {
    ids.push(key);
    localStorage.setItem('notifiedTasks', JSON.stringify(ids));
  }
}

function isAlreadyNotified(id_tache, type) {
  const ids = getNotifiedTaskIds();
  return ids.includes(`${id_tache}_${type}`);
}

// === Affiche une notif push ===
function pushNotification(title, body) {
  if (Notification.permission === 'granted') {
    new Notification(title, {
      body: body,
      icon: '../images/login.jpg' // chemin à adapter si nécessaire
    });
  }
}

// === Exécution régulière ===
setInterval(() => {
  // 🔔 Rappel des tâches urgentes
  fetch('check_taches_urgentes.php')
    .then(res => res.json())
    .then(data => {
      data.forEach(tache => {
        const minutes = parseInt(tache.minutes_restantes);
        let label = '';
        let type = '';

        if (minutes >= 59 && minutes <= 61) {
          label = `🕐 Rappel : "${tache.titre}" dans 1 heure`;
          type = '1h';
        } else if (minutes >= 9 && minutes <= 11) {
          label = `⏳ URGENT : "${tache.titre}" dans 10 min`;
          type = '10m';
        }

        if (label && !isAlreadyNotified(tache.id_tache, type)) {
          pushNotification("Tâche à venir", label);
          saveNotifiedTaskId(tache.id_tache, type);
        }
      });
    })
    .catch(err => console.error('❌ Erreur rappel tâches urgentes :', err));

  // 🆕 Notification si nouvelle tâche ajoutée (par un autre membre)
  fetch('check_new_task.php')
    .then(res => res.json())
    .then(data => {
      if (data && data.action === 'nouvelle_tache') {
        pushNotification(
          `Nouvelle tâche dans ${data.groupe}`,
          `"${data.titre}" ajoutée par ${data.createur}`
        );
      }
    })
    .catch(err => console.error('❌ Erreur notif nouvelle tâche :', err));

}, 60000); // toutes les 1 min 