<?php 
header('Content-Type: application/json');
include '../bdd.php';
session_start();
if(!isset($_SESSION['email'])){
    header('Location: ../page/conn.php');
} ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add</title>
</head>
<body>
<?php 

    // Ajouter une tâche
    if (isset($_POST['add_task'])) {
        $titre = htmlspecialchars(filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_SPECIAL_CHARS));
        $description = htmlspecialchars(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS));
        $id_user = htmlspecialchars($_SESSION['id_user']);
        $deadline= htmlspecialchars(filter_input(INPUT_POST, 'deadline', FILTER_SANITIZE_SPECIAL_CHARS));

    
        if ($deadline ) {
            $deadline_date = date('Y-m-d H:i:s', strtotime($deadline));
            if (strtotime($deadline_date) < time()) {
                die('La date limite ne peut pas être dans le passé.');
            }
        } else {
            $deadline = "null";
        }
        
    // $reminder_time_int = $reminder_time ? intval($reminder_time) : null;


        $sql = "INSERT INTO taches (titre, description, deadline, id_user) VALUES (:titre, :description, :deadline, :id_user)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':deadline', $deadline);
        $stmt->bindParam(':id_user', $id_user);

        if ($stmt->execute()) {
            echo "Tâche ajoutée avec succès.";
            header ('Location: ../page/index.php');
        } else {

            echo "Une erreur s'est produite lors de l'ajout de la tâche.";
        }
        
    }else{
        echo "Une erreur s'est produite";
    }

    // add_task_gp

    if (isset($_POST['add_task_gp'])) {
        $titre = htmlspecialchars(filter_input(INPUT_POST, 'titre_tache_gp', FILTER_SANITIZE_SPECIAL_CHARS));
        $description = htmlspecialchars(filter_input(INPUT_POST, 'description_tache_gp', FILTER_SANITIZE_SPECIAL_CHARS));
        $id_user = $_SESSION['id_user'];
        $pseudo = $_SESSION['pseudo'];
        $id_gp = htmlspecialchars(filter_input(INPUT_POST, 'id_gp', FILTER_SANITIZE_SPECIAL_CHARS));
        $deadline = htmlspecialchars(filter_input(INPUT_POST, 'deadline_tache_gp', FILTER_SANITIZE_SPECIAL_CHARS));

        if ($deadline) {
            $deadline_date = date('Y-m-d H:i:s', strtotime($deadline));
            if (strtotime($deadline_date) < time()) {
                die('La date limite ne peut pas être dans le passé.');
            }
        } else {
            $deadline_date = null;
        }

        // ajouter la tâche dans la base
        $sql = "INSERT INTO task_gp (titre_gp, description_gp, deadline_gp, id_gp, cree_par) 
                VALUES (:titre_gp, :description_gp, :deadline_gp, :id_gp, :cree_par)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':titre_gp', $titre);
        $stmt->bindParam(':description_gp', $description);
        $stmt->bindParam(':deadline_gp', $deadline_date);
        $stmt->bindParam(':id_gp', $id_gp);
        $stmt->bindParam(':cree_par', $id_user);

        if ($stmt->execute()) {
            // Récupérer le nom du groupe
            $stmtGp = $conn->prepare("SELECT nom_gp FROM groups WHERE id_gp = :id_gp");
            $stmtGp->execute([':id_gp' => $id_gp]);
            $groupe = $stmtGp->fetch(PDO::FETCH_ASSOC);
            
            //  mettre les donne dans un tableau 
            $new_tache=[
                'titre_gp' => $titre,
                'description_gp' => $description,
                'deadline_gp' => $deadline_date,
                'id_gp' => $id_gp,
                'nom_gp' => $groupe['nom_gp'],
                'cree_par' => $id_user
            ];

            echo json_encode($taches);

            header("Location: ../page/group.php?id_gp=" . $id_gp);
            exit();
        } else {
            echo "Une erreur s'est produite lors de l'ajout de la tâche.";
        }
    }

?>

</body>
</html>
