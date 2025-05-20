<?php
$tab = [3, 5]; // Délais en minutes
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Notification automatique</title>
</head>
<body>
  <h2>Notifications programmées depuis PHP</h2>
  <ul>
    <?php foreach ($tab as $min): ?>
      <li>Notification prévue dans <?= $min ?> minute(s)</li>
    <?php endforeach; ?>
  </ul>

  <script>
    // Enregistre le Service Worker
    if ('Notification' in window && navigator.serviceWorker) {
      navigator.serviceWorker.register('sw.js').then(() => {
        console.log('Service Worker enregistré');
      });

      Notification.requestPermission().then(permission => {
        if (permission !== 'granted') {
          alert("Autorisez les notifications pour que les rappels fonctionnent.");
        }
      });
    }

    // Notifications depuis PHP
    const rappels = <?php echo json_encode($tab); ?>;

    rappels.forEach(minutes => {
      const delay = minutes * 60 * 1000; // en ms
      setTimeout(() => {
        if (Notification.permission === 'granted') {
          navigator.serviceWorker.ready.then(reg => {
            reg.showNotification("⏰ Rappel automatique", {
              body: `Ceci est votre rappel après ${minutes} minute(s).`,
              icon: 'https://cdn-icons-png.flaticon.com/512/565/565547.png',
              tag: 'rappel-' + minutes
            });
          });
        }
      }, delay);
    });
  </script>
</body>
</html>
