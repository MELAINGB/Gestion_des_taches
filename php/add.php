<?php include '../bdd.php';
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
?>

</body>
</html>
