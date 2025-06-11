<?php include '../bdd.php';
session_start();
// Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
if(!isset($_SESSION['email'])){
    header('Location: conn.php');
}?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Groupes</title>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }
        .main {
            max-width: 800px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .create-group form {
            display: flex;
            flex-direction: column;
        }
        .create-group input[type="text"] {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .create-group button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .create-group button:hover {
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
        .group-list a {
            text-decoration: none;
            color: #007bff;
        }
        .group-list a:hover {
            text-decoration: underline;
        }
        .group-list ion-icon {
            margin-right: 5px;
        }
        .group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .name-gp {
            font-weight: bold;
        }
        .action-gp {
            display: flex;
            gap: 10px;
        }
        .action-gp a {
            color: #333;
            text-decoration: none;
            font-size: 1.5rem;
        }
        .action-gp a:hover {
            color: #007bff;
        }
            @media screen and (max-width: 768px) {
        .main {
            padding: 10px;
        }

        .group-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .action-gp {
            width: 100%;
            justify-content: flex-start;
        }

        .action-gp a {
            font-size: 1.2rem;
        }

        .create-group form {
            width: 100%;
        }

        .create-group input[type="text"],
        .create-group button {
            width: 100%;
        }
}

        
    </style>
</head>

<body>
<?php include 'header.php'; ?>

    <div class="main">
        <h2>Créer un Groupe</h2>
        <div class="create-group">
            <form action="" method="post">
                <input type="text" name="group_name" placeholder="Nom du groupe" required>
                <button type="submit" name="create_group">Créer un groupe</button> 

            </form>

            <?php 
            if (isset($_POST['create_group'])) {
                $group_name = filter_input(INPUT_POST, 'group_name', FILTER_SANITIZE_STRING);

                // Vérification si le groupe existe déjà
                $sql = "SELECT * FROM groups WHERE nom_gp = :group_name";
                $stmt = $conn->prepare($sql);   
                $stmt->bindParam(':group_name', $group_name, PDO::PARAM_STR);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    echo "<h5>Ce nom n'est pas disponible, Réessayez avec autre</h5>";
                    exit();
                }else{
                    // Insertion du groupe dans la base de données
                    $sql = "INSERT INTO groups (nom_gp, created_by) VALUES (:group_name, :created_by)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':group_name', $group_name, PDO::PARAM_STR);
                    $stmt->bindParam(':created_by', $_SESSION['id_user'], PDO::PARAM_INT);
                    $stmt->execute();
                    $id_gp = $conn->lastInsertId(); 
                    // Insertion de l'utilisateur dans le groupe

                    //  Verif if the user is already in the group

                    $sql = "SELECT * FROM membres_gp WHERE id_user = :id_user AND id_gp = :id_gp";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':id_user', $_SESSION['id_user'], PDO::PARAM_INT);
                    $stmt->bindParam(':id_gp', $id_gp, PDO::PARAM_INT);
                    $stmt->execute();
                    if ($stmt->rowCount() > 0) {
                        echo "<h5>Cet utilisateur est déjà daan le groupe</h5>";
                        exit();
                    }else{
                        //  Insertion de l'utilisateur dans le groupe
                        $sql = "INSERT INTO membres_gp (id_user, id_gp) VALUES (:id_user, :id_gp)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':id_user', $_SESSION['id_user'], PDO::PARAM_INT);
                        $stmt->bindParam(':id_gp', $id_gp, PDO::PARAM_INT);
                        $stmt->execute();  
                        
                        echo '<div id="success-message" style="color: green; margin-top: 10px;">Groupe créé avec succès</div>';
                        echo '<script>
                            setTimeout(function() {
                                var msg = document.getElementById("Groupe créé avec succès");
                                if(msg) msg.style.display = "none";
                            }, 3000);
                        </script>';

                    }
 

                }
               
            }
            ?>
            
        </div>

        <h2>Mes Groupes</h2>
        <div class="group-list">
            <?php 
            $sql = "SELECT * FROM groups join membres_gp on groups.id_gp = membres_gp.id_gp WHERE id_user = :id_user";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_user', $_SESSION['id_user'], PDO::PARAM_INT);
            $stmt->execute();
            $groupes = $stmt->fetchAll(PDO::FETCH_ASSOC);
         
        //    Affichage des groupes
            foreach ($groupes as $gp) {?>
               
            <ul>
              
                <li>
                    <div class="group-item">
                        <div class="name-gp"><a href="group.php?id_gp=<?php echo $gp['id_gp']; ?>"><?php echo $gp['nom_gp']; ?></a> </div>
                        <div class="action-gp">
                            <a href="#"><ion-icon name="create-outline"></ion-icon></a>
                            <a href="../php/delete.php?id_gps=<?= $gp['id_gp'] ?>"><ion-icon name="trash-outline"></ion-icon></a>
                        </div>
                    </div>
                </li>
               <?php } ?>
            </ul>
        </div>
    </div>
</body>
</html>