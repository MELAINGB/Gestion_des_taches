<?php 
include 'bdd.php';
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
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <script  type = "module"  src = "https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" > </script> 
    <script  nomodule  src = "https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" > </script>
    <title>Notifications de mes tâches </title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }

        .notifs {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .notifs ul {
            list-style-type: none;
            padding: 0;
        }

        .notifs li {
            background-color: #e7f3fe;
            margin: 10px 0;
            padding: 10px;
            border-left: 5px solid #2196F3;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notifs li a {
            text-decoration: none;
            color: #2196F3;
            font-weight: bold;
        }

        .notifs li a:hover {
            text-decoration: underline;
        }

        .notifs li:hover {
            background-color: #d0e7fd;
        }
        p{
            text-align: center;
            color: #333;
            margin-top: 20px;
        }
        #icon {
        color: #2196F3;
        font-size: 48px;
        transition: transform 0.3s ease;
        display: block;
        margin: 0 auto;
        margin-top: 5rem;
        }

        #icon:hover {
            transform: scale(1.2);
            color: #1769aa;
        }
        p {
            text-align: center;
            margin-top: 20px;
            font-size: 2rem;
        }
       
    </style>

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

