<?php include 'bdd.php';
session_start();
// Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
if(!isset($_SESSION['email'])){
    header('Location: conn.php');
}?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <title>Mes tâches</title>
   <style>
    /* Styles de base */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 0;
    color: #333;
}

.app-container {
    max-width: 800px;
    margin: 2rem auto;
    padding: 1rem;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #007BFF;
    margin-bottom: 1.5rem;
}

.tasks ul {
    list-style: none;
    padding: 0;
}

.task-item {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 10px;
    margin-bottom: 1rem;
    padding: 1rem;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.task-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
}

.task-content h3 {
    margin: 0;
    font-size: 1.25rem;
    color: #007BFF;
}

.task-content p {
    margin: 0.5rem 0;
    color: #555;
}

.status-btn {
    border: none;
    border-radius: 5px;
    color: #fff;
    font-size: 1rem;
    padding: 5px 10px;                   
    float: right;
    margin-top: -60px;
}
i {
    font-style: italic;
    color: #888;
    font-size: 1.1rem;
    color:rgb(219, 38, 6); 
    font-weight: bold; 

}

/* Responsive Design */
@media (max-width: 1200px) {
    .app-container {
        padding: 1rem;
        max-width: 100%;
        margin: 0;
        border-radius: 0;
    }

    .task-item {
        padding: 0.75rem;
    }
    .task-item {
    animation: fadeIn 0.5s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .task-content h3 {
        font-size: 1.1rem;
    }

    .task-content p {
        font-size: 0.9rem;
    }

    .status-btn {
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        font-size: 0.8rem;
        color: white;
        float: right;
        margin-top: -50px;
    }
}

   </style>
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