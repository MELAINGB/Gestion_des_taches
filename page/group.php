<?php 
session_start();
if(!isset($_SESSION['email'])){
    header('Location: conn.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des groupes</title>
     <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>
        body{
            background-color: #f0f0f0;
        }
        .main {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
        }
        button ion-icon {
            margin-right: 5px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .group-list {
            margin-top: 20px;
        }
        .group-list ul {
            list-style-type: none;
            padding: 0;
        }
        .group-list li {
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .group-list li:hover {
            background-color: #e9ecef;
        }

        ion-icon {
            font-size: 20px;
        }

        .group-list li:last-child {
            margin-bottom: 0;
        }
        .group-list li a {
            text-decoration: none;
            color: #333;
        }
        .group-list li a:hover {
            color: #007bff;
        }
        .group-list button {
            padding: 5px 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .group-list button:hover {
            background-color: #218838;
        }
        .group-actions {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .group-actions button {
            flex: 1;
            margin-right: 10px;
        }
        .group-actions button:last-child {
            margin-right: 0;
        }
        .group-actions ion-icon {
            margin-right: 5px;
        }
        .group-actions button:hover {
            background-color: #0056b3;
        }
        .group-actions button ion-icon {
            font-size: 20px;
        }
    </style>
</head>
<body>
<?php include 'header.php'; 
include '../bdd.php';
$id_gp = $_GET['id_gp'] ?? null;
    $sql = "SELECT * FROM task_gp join membres_gp on task_gp.id_gp = membres_gp.id_gp join groups on task_gp.id_gp = groups.id_gp WHERE task_gp.id_gp = :id_gp AND statut = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_gp', $id_gp, PDO::PARAM_INT);
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC); 

    foreach ($tasks as $row) {
        // if ($row['deadline'] == "0000-00-00 00:00:00") {
        //     $row['deadline'] = "Pas définie";
        // }
?>
    <div class="main">
        <h1><?php echo htmlspecialchars($row['nom_gp']); ?></h1>

        <div class="group-actions">
        <button >
            <ion-icon name="add-outline"></ion-icon> Ajouter une tâche
        </button>
       <button>
            <ion-icon name="people"></ion-icon>Membres    
       </button>


        </div>
       
        <div class="group-list">
            <!-- liste des taches -->
            <ul>
                 <li class="task-item">
                        <div class="task-content">
                            <h2><?php echo htmlspecialchars($row['titre_gp']); ?></h2>
                            <p><?php echo htmlspecialchars($row['description_gp']); ?></p>
                            <i>Échéance : <?php echo htmlspecialchars($row['deadline_gp']); ?></i>
                        </div>

                        <div class="task-actions">
                            <ion-icon id="toggleActions<?= $row['id_tach_gp'] ?>" name="ellipsis-horizontal-outline" class="action-toggle"></ion-icon>
                            <div id="actionLinks<?= $row['id_tach_gp'] ?>" class="action-links">
                                <a href="../php/done.php?id_tache=<?= $row['id_tach_gp'] ?>" class="action-link"><ion-icon name="checkbox-outline"></ion-icon></a>
                                <a href="#" class="openModal action-link" data-id="<?= $row['id_tach_gp'] ?>" data-titre="<?= $row['titre_gp'] ?>" data-description="<?= $row['description_gp'] ?>"><ion-icon name="create-outline"></ion-icon></a>
                                <a href="../php/delete.php?id_tache=<?= $row['id_tach_gp'] ?>" class="action-link"><ion-icon name="trash-outline"></ion-icon></a>
                            </div>
                        </div>
                    </li>
            </ul>

        </div>
<?php } ?>
 
    </div>
</body>
</html>