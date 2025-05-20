<?php
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$message = $data['message'] ?? "Rappel de tâche en cours.";

echo json_encode(["status" => "success", "message" => $message]);
?>