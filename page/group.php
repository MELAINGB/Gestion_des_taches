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
    <link rel="stylesheet" href="../style/pop-up.css">

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
     // }
        $id_gp = $_GET['id_gp'] ?? null;
        // verifier si l'utilisateur est membre du groupe
        $id_gp = $_GET['id_gp'] ?? null;

        if (!$id_gp) {
            echo "<p style='color:red;'>Aucun groupe sélectionné.</p>";
            exit;
        }

        // ⚠️ Sécurité : Vérifier si l'utilisateur fait bien partie de ce groupe
        $id_user = $_SESSION['id_user'];

        $sql = "SELECT * FROM membres_gp WHERE id_gp = :id_gp AND id_user = :id_user";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'id_gp' => $id_gp,
            'id_user' => $id_user
        ]);

        if ($stmt->rowCount() === 0) {
            echo "<p style='color:red;'>⛔ Accès refusé : vous ne faites pas partie de ce groupe.</p>";
            exit;
        }

        $sql = "SELECT DISTINCT * FROM task_gp join membres_gp on task_gp.id_gp = membres_gp.id_gp join groups on task_gp.id_gp = groups.id_gp join utilisateurs on membres_gp.id_user = utilisateurs.id_user WHERE task_gp.id_gp = :id_gp AND statut = 0 GROUP BY task_gp.id_tach_gp";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_gp', $id_gp, PDO::PARAM_INT);
        $stmt->execute();
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC); 
?>
    <div class="main">
        <div class="group-header" style="display: flex; justify-content: space-between; align-items: center;"> 
            <h1> <?php echo $tasks[0]['nom_gp']; ?> </h1>
            <button id="openAddMemberModal"><ion-icon name="person-add"></ion-icon>Ajouter un membre</button>
            
        </div> 
        <div class="group-actions">
            <button id="openAddTaskModal" onclick="openForm()">
                <ion-icon name="add-outline"></ion-icon> Ajouter une tâche
            </button>

            <button id="openMembersModal">
                <ion-icon name="people"></ion-icon>Membres    
            </button>

        </div>
        <?php 
       
        if (empty($tasks)) {
            echo '<p>Aucune tâche dans ce groupe.</p>';
        }else{ 
        
            foreach ($tasks as $row) {
            // Formater la date d'échéance
            $row['deadline_gp']=="0000-00-00 00:00:00" ? $row['deadline_gp'] = "Pas définie":  $row['deadline_gp'] = date('Y-m-d H:i', strtotime($row['deadline_gp']));?>
        
        
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
                                    <a href="../php/done.php?id_tach_gp=<?= $row['id_tach_gp'] ?> & id_gp=<?= $row['id_gp'] ?> & id_user=<?= $id_user ?>" class="action-link"><ion-icon name="checkbox-outline"></ion-icon></a>
                                    <a href="#" class="openModal action-link" data-id="<?= $row['id_tach_gp'] ?>" data-titre="<?= $row['titre_gp'] ?>" data-description="<?= $row['description_gp'] ?>"><ion-icon name="create-outline"></ion-icon></a>
                                    <a href="../php/delete.php?id_tach_gp=<?= $row['id_tach_gp'] ?> & id_gp=<?= $row['id_gp'] ?> " class="action-link"><ion-icon name="trash-outline"></ion-icon></a>
                                </div>
                            </div>
                        </li>
                </ul>

            </div>
        
        <?php } }
            // Créateru du groupe 
            $sql_creator = "SELECT pseudo FROM utilisateurs WHERE id_user = (SELECT created_by FROM groups WHERE id_gp = :id_gp)";
            $stmt_creator = $conn->prepare($sql_creator);
            $stmt_creator->bindParam(':id_gp', $id_gp, PDO::PARAM_INT);
            $stmt_creator->execute();
            $creator = $stmt_creator->fetch();
            echo "<i>Créé par : " . htmlspecialchars($creator['pseudo']) . "</i>";

        ?>

     <!-- pop-up -->

       <div class="form-popup" id="myForm">
            <form action="../php/add.php" method="post" class="form-container">
                <a href="#" class="close" onclick="closeForm()">❌</a> 
                <h2>Ajouter une tâche</h2> 
                
                <input type="text" placeholder="Entrez le titre de la tâche" name="titre_tache_gp" required>            
                <input type="text" placeholder="Entrez la description de la tâche" name="description_tache_gp" required>
                <input type="datetime-local" id="date-tache" name="deadline_tache_gp" >
                <input type="hidden" name="id_gp" value="<?php echo $id_gp; ?>">
                <input type="hidden" name="created_by" value="<?php echo $id_user; ?>">

                <button type="submit" class="btn" name="add_task_gp">Ajouter</button>
            </form>
        </div>

        <!-- Overlay -->
        <div class="overlay" id="overlay"></div>
    </div>

    <script>
        function openForm() {
            document.getElementById("myForm").style.display = "block";
            document.getElementById("overlay").style.display = "block";
        }
        function closeForm() {
            document.getElementById("myForm").style.display = "none";
            document.getElementById("overlay").style.display = "none";
        }
    </script>

        <!-- pop-up pour voir les membres -->

        <!-- Modal pour afficher les membres du groupe -->
        <div class="form-popup group-list" id="membersModal" style="display:none;">
            <form class="form-container" onsubmit="return false;">
                <a href="#" class="close" onclick="closeMembersModal()">❌</a>
                <h2>Membres du groupe</h2>
                
                <ul>
                    <?php
                    // Récupérer les membres du groupe
                    $sql_members = "SELECT utilisateurs.pseudo FROM membres_gp 
                                    JOIN utilisateurs ON membres_gp.id_user = utilisateurs.id_user 
                                    WHERE membres_gp.id_gp = :id_gp ";
                    $stmt_members = $conn->prepare($sql_members);
                    $stmt_members->bindParam(':id_gp', $id_gp, PDO::PARAM_INT);
                    $stmt_members->execute();
                    $membres = $stmt_members->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($membres as $membre) {?>

                        <li class="task-item" style="display: flex; justify-content: space-between; align-items: center;">
                            <h3><?php echo htmlspecialchars($membre['pseudo']); ?></h3> <button>Nommer admin</button> <a href="#"><ion-icon name="trash"></ion-icon></a> 
                        </li>
                    
                   <?php }
                    ?>
                    
                </ul>
            </form>
        </div>
        <script>
            document.getElementById("openMembersModal").onclick = function() {
                document.getElementById("membersModal").style.display = "block";
                document.getElementById("overlay").style.display = "block";
            };
            function closeMembersModal() {
                document.getElementById("membersModal").style.display = "none";
                document.getElementById("overlay").style.display = "none";
            }
        </script>

        <!-- pop-up pour ajouter un membre -->
        <div class="form-popup" id="addMemberModal" style="display:none;">
            <form class="form-container" action="" method="post">
                <a href="#" class="close" onclick="closeAddMemberModal()">❌</a>
                <h2>Ajouter un membre</h2>
                
                <input type="text" placeholder="Entrez l'email du membre" name="email_membre" required>
                <input type="hidden" name="id_gp" value="<?php echo $id_gp; ?>">
                
                <button type="submit" class="btn" name="add_member">Ajouter</button>
            </form>
            <?php
            if(isset($_POST['add_member'])) {
                $email_membre = filter_input(INPUT_POST, 'email_membre', FILTER_SANITIZE_EMAIL);
                $id_gp = filter_input(INPUT_POST, 'id_gp', FILTER_SANITIZE_NUMBER_INT);

                // Vérifier si l'utilisateur existe
                $sql_user = "SELECT id_user FROM utilisateurs WHERE email = :email";
                $stmt_user = $conn->prepare($sql_user);
                $stmt_user->bindParam(':email', $email_membre, PDO::PARAM_STR);
                $stmt_user->execute();
                $user = $stmt_user->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    // Ajouter l'utilisateur au groupe
                    $sql_add_member = "INSERT INTO membres_gp (id_user, id_gp) VALUES (:id_user, :id_gp)";
                    $stmt_add_member = $conn->prepare($sql_add_member);
                    $stmt_add_member->bindParam(':id_user', $user['id_user'], PDO::PARAM_INT);
                    $stmt_add_member->bindParam(':id_gp', $id_gp, PDO::PARAM_INT);
                    if ($stmt_add_member->execute()) {
                        echo '<div id="success-message" style="color: green; margin-top: 10px;">Membre ajouté avec succès</div>';
                    } else {
                        echo '<div id="error-message" style="color: red; margin-top: 10px;">Erreur lors de l\'ajout du membre</div>';
                    }
                } else {
                    echo '<div id="error-message" style="color: red; margin-top: 10px;">Utilisateur non trouvé</div>';
                }


            }?>
        </div>
        <script>
            document.getElementById("openAddMemberModal").onclick = function() {
                document.getElementById("addMemberModal").style.display = "block";
                document.getElementById("overlay").style.display = "block";
            };
            function closeAddMemberModal() {
                document.getElementById("addMemberModal").style.display = "none";
                document.getElementById("overlay").style.display = "none";
            }
        </script>

       
    </div>
</body>
</html>