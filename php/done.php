<?php include '../bdd.php';

if(isset($_GET['id_tache'])){
    $id = $_GET['id_tache'];
    $sql = "UPDATE taches SET statut = 1 WHERE id_tache = $id";
    $conn->query($sql);
    
    if($conn){
        header('Location: ../page/index.php');
    }else{
        echo "Quelque chose s'est mal passée";
    }
}

if(isset($_GET['id_tach_gp'])){
    $id = $_GET['id_tach_gp'];
    $id_user = $_GET['id_user'];
    $sql = "UPDATE task_gp SET statut = 1, modifier_par = :id_user WHERE id_tach_gp = $id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();
   
    
    if($stmt){
        header('Location: ../page/group.php?id_gp='.$_GET['id_gp']);
    }else{
        echo "Quelque chose s'est mal passée";
    }
}

?>