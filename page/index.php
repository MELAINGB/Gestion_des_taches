<?php include '../bdd.php';
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
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <title>Gestion des tâches</title>
    <link rel="stylesheet" href="../style/styles.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body>
    
    <!--<div class="search-bar">
    <input type="text" id="searchInput" placeholder="Rechercher une tâche...">
    <button onclick="searchTasks()"><ion-icon name="search-outline"></ion-icon></button>
</div>
<script>
    function searchTasks() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const tasks = document.querySelectorAll('.task-item');

    tasks.forEach(task => {
        const title = task.querySelector('h3').textContent.toLowerCase();
        const description = task.querySelector('p').textContent.toLowerCase();
        if (title.includes(searchTerm) || description.includes(searchTerm)) {
            task.style.display = 'block';
        } else {
            task.style.display = 'none';
        }
    });
}
</script>-->
    <?php include 'header.php'; ?>

    <div class="app-container">
        <!-- Formulaire d'ajout de tâche -->
        <form method="post" action="../php/add.php" class="task-form">
            <input type="text" name="titre" placeholder="Titre" maxlength="40" required>
            <input type="text" name="description" placeholder="Description (Facultative)" maxlength="50">
            <div class="form-group">
                <label for="deadline">Date limite (facultative) :</label>
                <input type="datetime-local" id="deadline" name="deadline">
                <button type="submit" name="add_task" class="btn-add">Ajouter</button>
            </div>
        </form>

        <!-- Liste des tâches -->
        <h2 class="section-title">📝 Tâches en cours</h2>
        <style>
            .section-title {
            font-size: 1.2rem;
            color: #2d4059;
            padding: 0.5rem;
            margin-bottom: 20px;
            text-align: left;
            letter-spacing: 1px;
            font-weight: 700;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(45,64,89,0.08);
            display: inline-block;
            }
        </style>
        <div class="tasks">
           
            <ul>
                <?php include '../bdd.php';
                $id = $_SESSION['id_user'];

                // Récupérer toutes les tâches
                $sql = "SELECT * FROM taches WHERE id_user = $id AND statut = 0 ORDER BY deadline";
                $result = $conn->query($sql);
                // Compter le nombre de tâches restantes
                $sqlcompt = "SELECT COUNT(*) FROM taches WHERE id_user = $id AND statut = 0";
                $resultcompt = $conn->query($sqlcompt);
                $rowcompt = $resultcompt->fetch();
                echo "<h3>Vous avez ".$rowcompt[0]." restantes</h3>";
               


                foreach ($result as $row) {
                    if ($row['deadline'] == "0000-00-00 00:00:00") {
                        $row['deadline'] = "Pas définie";
                    }
                ?>
                    <li class="task-item">
                        <div class="task-content">
                            <h2><?php echo htmlspecialchars($row['titre']); ?></h2>
                            <p><?php echo htmlspecialchars($row['description']); ?></p>
                            <i>Échéance : <?php echo htmlspecialchars($row['deadline']); ?></i>
                        </div>

                        <div class="task-actions">
                            <ion-icon id="toggleActions<?= $row['id_tache'] ?>" name="ellipsis-horizontal-outline" class="action-toggle"></ion-icon>
                            <div id="actionLinks<?= $row['id_tache'] ?>" class="action-links">
                                <a href="../php/done.php?id_tache=<?= $row['id_tache'] ?>" class="action-link"><ion-icon name="checkbox-outline"></ion-icon></a>
                                <a href="#" class="openModal action-link" data-id="<?= $row['id_tache'] ?>" data-titre="<?= $row['titre'] ?>" data-description="<?= $row['description'] ?>"><ion-icon name="create-outline"></ion-icon></a>
                                <a href="../php/delete.php?id_tache=<?= $row['id_tache'] ?>" class="action-link"><ion-icon name="trash-outline"></ion-icon></a>
                            </div>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <!-- Modal pour la modification de tâche -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Modifier une tâche</h2>
            <form method="post" action="../php/update.php">
                <input type="hidden" name="id_tache" id="modal_id_tache">
                <input type="text" name="titre" id="modal_titre" maxlength="40" required>
                <input type="text" name="des" id="modal_description" maxlength="50">
                <input type="datetime-local" id="modal-date" name="deadline">
                <button type="submit" name="update_task" class="btn-update">Modifier</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            var modal = document.getElementById("myModal");
            var span = document.getElementsByClassName("close")[0];

            document.querySelectorAll('.openModal').forEach(item => {
                item.addEventListener('click', event => {
                    var id = item.getAttribute('data-id');
                    var titre = item.getAttribute('data-titre');
                    var description = item.getAttribute('data-description');

                    document.getElementById('modal_id_tache').value = id;
                    document.getElementById('modal_titre').value = titre;
                    document.getElementById('modal_description').value = description;

                    modal.style.display = "block";
                });
            });

            span.onclick = function() {
                modal.style.display = "none";
            };

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            };

            // Gestion des actions (trois points)
            document.querySelectorAll('.action-toggle').forEach(toggle => {
                toggle.addEventListener('click', function() {
                    var actionLinks = this.nextElementSibling;
                    if (actionLinks.style.display === 'none' || !actionLinks.style.display) {
                        actionLinks.style.display = 'flex';
                    } else {
                        actionLinks.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>
