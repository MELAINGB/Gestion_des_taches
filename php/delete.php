<?php include '../bdd.php';

if(isset($_GET['id_tache'])){
    $id = $_GET['id_tache'];
    $sql = "DELETE FROM taches WHERE id_tache=$id";
    $conn->query($sql);
    header('Location: ../page/index.php');
}


if(isset($_GET['id_gps'])){
    $id = $_GET['id_gps'];
    $sql = "DELETE FROM groups WHERE id_gp=$id";
    $conn->query($sql);
    header('Location: ../page/groups.php');
}
else{
    echo "Aucune tâche à supprimer.";
}

if(isset($_GET['id_tach_gp'])){
    $id = $_GET['id_tach_gp'];
    $sql = "DELETE FROM task_gp WHERE id_tach_gp=$id";
    $conn->query($sql);

    header('Location: ../page/group.php?id_gp='.$_GET['id_gp']);
    
     
}
else{
    echo "Aucune tâche à supprimer.";
}


?>

