<?php
session_start();
if(!isset($_SESSION['email'])){
    header('Location: ../page/conn.php');
}
header('Content-Type: application/json');


// Vérifie que l'utilisateur est connecté
$id_user = $_SESSION['id_user'] ?? null;
if (!$id_user) {
    echo json_encode([]);
    exit;
}

// Chemin vers le fichier de notification (ex : tache_new_5.json)
$notifFile = __DIR__ . "/tache_new_{$id_user}.json";

// Si le fichier n'existe pas, rien à envoyer
if (!file_exists($notifFile)) {
    echo json_encode([]);
    exit;
}

// Lire le fichier JSON et envoyer son contenu
$data = json_decode(file_get_contents($notifFile), true);

// Supprimer le fichier une fois la notif lue (évite les doublons)
unlink($notifFile);

// Renvoyer les données JSON au navigateur
echo json_encode($data);
