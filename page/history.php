<?php include '../bdd.php';
session_start();
// Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
if(!isset($_SESSION['email'])){
    header('Location: conn.php');
}?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style/history.css">
    <title>Mes tâches</title>
   
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="app-container">
        <h1>Mes tâches</h1>
        <div class="tasks">
            <ul>
                <?php 
                $id = $_SESSION['id_user'];
                $sql = "SELECT * FROM taches JOIN utilisateurs ON utilisateurs.id_user = taches.id_user WHERE taches.id_user = '$id' ORDER BY statut";
                $result = $conn->query($sql);

                // Nombres de tâches restantes
                $sqlcompt1 = "SELECT COUNT(*) FROM taches WHERE id_user = $id AND statut = 0";
                $resultcompt1 = $conn->query($sqlcompt1);
                $rowcompt1 = $resultcompt1->fetch();

                $sqlcompt = "SELECT COUNT(*) FROM taches WHERE id_user = $id AND statut = 0 AND deadline < NOW()";
                $resultcompt = $conn->query($sqlcompt);
                $rowcompt = $resultcompt->fetch();
                echo "<i> ".$rowcompt1[0]." tâche(s) restante(s) avec ".$rowcompt[0]." tâche(s) en retard</i>";

                if ($result->rowCount() > 0) {
                    foreach ($result as $resulte) {
                        if ($_SESSION['email'] == $resulte['email']) {
                            if ($resulte['statut'] == 0) {
                                if ($resulte['deadline'] < date('Y-m-d H:i:s', time()) ) {
                                    $resulte['statut'] = "En retard";
                                    $color = "#dc3545"; // Rouge pour les tâches en retard 
                                }else{
                                    $resulte['statut'] = "En cours";
                                $color = "#f2b706"; // Orange pour les tâches en cours
                                    
                                }
                                
                            } else {
                                $resulte['statut'] = "Terminée";
                                $color = "#4CAF50"; // Vert pour les tâches terminées
                            }
                ?>
                            <li class="task-item">
                                <div class="task-content">
                                    <h3><?php echo htmlspecialchars($resulte['titre']); ?></h3>
                                    <p><?php echo htmlspecialchars($resulte['description']); ?></p>
                                    <button class="status-btn" style="background-color: <?php echo htmlspecialchars($color); ?>"><?php echo htmlspecialchars($resulte['statut']); ?></button>
                                </div>
                            </li>
                <?php
                        } else {
                            echo "<p>Une erreur s'est produite.</p>";
                        }
                    }
                } else {
                    echo "<h3>Aucune tâche pour l'instant.</h3>";
                }
                ?>
            </ul>
            
        </div>
    </div>
</body>
</html>