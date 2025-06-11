<?php
session_start();
header('Content-Type: application/json');
include '../bdd.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$id_user = $_SESSION['id_user'] ?? null;

if (!$id_user) {
    echo json_encode([]);
    exit;
}

// Tâches urgentes (moins de 3 jours)
$sql = "SELECT id_tache, titre, deadline,
        TIMESTAMPDIFF(MINUTE, NOW(), deadline) AS minutes_restantes
        FROM taches 
        WHERE id_user = :id_user 
        AND statut = 0 
        AND deadline IS NOT NULL 
        AND (
            (deadline <= NOW() + INTERVAL 10 MINUTE AND deadline > NOW() + INTERVAL 9 MINUTE)
            OR
            (deadline <= NOW() + INTERVAL 1 HOUR AND deadline > NOW() + INTERVAL 59 MINUTE)
        )";


$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
$stmt->execute();

$taches = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($taches); 
