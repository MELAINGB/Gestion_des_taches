<?php
session_start();
include 'bdd.php'; // Inclure le fichier de connexion à la base de données

$id = $_SESSION['id_user'];
$tasks = [];

// Récupérer les tâches de l'utilisateur
$sql = "SELECT titre, deadline FROM taches WHERE id_user = :id AND statut = 0";
$stmt = $conn->prepare($sql);
$stmt->execute(['id' => $id]);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Convertir les tâches en JSON pour JavaScript
echo "<script>const tasks = " . json_encode($tasks) . ";</script>";

?>


<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Demander la permission pour les notifications
    if (Notification.permission !== 'granted' && Notification.permission !== 'denied') {
        Notification.requestPermission().then(permission => {
            if (permission === 'granted') {
                console.log('Permission accordée pour les notifications.');
                checkTasksForNotifications(tasks); // Vérifier les tâches après avoir obtenu la permission
            }
        });
    } else if (Notification.permission === 'granted') {
        checkTasksForNotifications(tasks); // Vérifier les tâches si la permission est déjà accordée
    }

    // Fonction pour afficher une notification
    function showNotification(title, message) {
        if (Notification.permission === 'granted') {
            new Notification(title, { body: message });
        }
    }

    // Fonction pour vérifier les tâches et envoyer des notifications
    function checkTasksForNotifications(tasks) {
        const today = new Date().toISOString().split('T')[0]; // Date du jour au format YYYY-MM-DD

        tasks.forEach(task => {
            if (task.deadline === today) {
                showNotification('Rappel de tâche', `La tâche "${task.titre}" est due aujourd'hui !`);
            }
        });
    }
});
</script>
