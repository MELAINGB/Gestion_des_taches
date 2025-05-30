document.getElementById('openModal').onclick = function() {
  document.getElementById('myModal').style.display = "block";
}

document.getElementsByClassName('close')[0].onclick = function() {
  document.getElementById('myModal').style.display = "none";
}

window.onclick = function(event) {
  if (event.target == document.getElementById('myModal')) {
      document.getElementById('myModal').style.display = "none";
  }
}




// Demander l'autorisation et enregistrer le Service Worker
if ('Notification' in window && navigator.serviceWorker) {
  navigator.serviceWorker.register('sw.js').then(() => {
    console.log('Service worker enregistré.');
  });

  Notification.requestPermission().then(permission => {
    if (permission !== 'granted') {
      alert('Vous devez autoriser les notifications pour utiliser cette fonctionnalité.');
    }
  });
}

function demarrerRappel(minutes) {
  const delay = minutes * 60 * 1000; // conversion en ms
  setTimeout(() => {
    envoyerNotification("🕒 Rappel", `Ceci est votre rappel après ${minutes} minute(s).`);
  }, delay);
}

function envoyerNotification(titre, message) {
  if (Notification.permission === 'granted') {
    navigator.serviceWorker.ready.then(registration => {
      registration.showNotification(titre, {
        body: message,
        icon: 'https://cdn-icons-png.flaticon.com/512/565/565547.png',
        tag: 'rappel-tache'
      });
    });
  }
}

function togglePassword() {
      var pwd = document.getElementById('password');
      if (pwd.type === 'password') {
        pwd.type = 'text';
      } else {
        pwd.type = 'password';
      }
      }
