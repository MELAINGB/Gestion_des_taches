<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mes_taches";

    // Créer une connexion
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Définir le mode d'erreur PDO à l'exception
        
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        #echo "Connected successfully";
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
?>


   