<?php include 'bdd.php';

if(isset($_GET['id_tache'])){
    $id = $_GET['id_tache'];
    $sql = "UPDATE taches SET statut = 1 WHERE id_tache = $id";
    $conn->query($sql);
    
    if($conn){
        header('Location: index.php');
    }else{
        echo "Quelque chose s'est mal passée";
    }
}

?>