<?php 
include '../bdd.php';
session_start();
// Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
if(!isset($_SESSION['email'])){
    header('Location: conn.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
    <script  type = "module"  src = "https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" > </script> 
    <script  nomodule  src = "https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" > </script>
    <title>Notifications de mes tâches </title>
    <link rel="stylesheet" href="../style/notif.css">

</head>
<body>
    <?php
        include "header.php";

        $now = time();
        $id = $_SESSION['id_user'];
        $alert_time = 2 * 60; // 5 minutes in seconds
        $notifs = []; // Initialiser le tableau pour éviter les warnings
        
        $sql = "SELECT * FROM taches WHERE id_user = $id AND statut = 0";
        $result = $conn->query($sql);

        foreach ($result as $row) {
            $deadline = strtotime($row['deadline']);

            if ($deadline - $now <= $alert_time && $deadline - $now > 0 ) {
                $notifs[] =   $row['titre']; 
            }
            if ($row['statut'] == 0) {
                $notifs[] =  $row['titre'];
            }
        }
    ?>
    <script>
       // Enregistre le service worker une seule fois
    if ('Notification' in window && navigator.serviceWorker) {
        navigator.serviceWorker.register('../script/service-worker.js').then(() => {
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
    const rappels = <?php echo json_encode($notifs); ?>;
    rappels.forEach(msg => {
        setTimeout(() => {
            showNotification("⏰ Rappel", "Tache non effectuée: " + msg);
        }, 3000); // petit délai pour éviter les conflits de chargement
    });
    </script>
    
    <?php
        // Affichage des notifications
        if (!empty($notifs)){?>
            <h1>Mes notifications</h1>
            <div class="notifs"><?php
            
                for ($i=0; $i<count($notifs); $i++){?>
            
                    <ul>
                        <li><b>Tâche non effectuée :</b><?php echo $notifs[$i]?><a href="index.php">Détails</a></li>
                    </ul>

                    <?php
                }?>
            </div><?php

        }else{
            echo '<ion-icon id="icon" name="receipt-outline"></ion-icon><p>Pas de notif pour le moment! </p>';
        }
    ?>
    
</body>
</html>

