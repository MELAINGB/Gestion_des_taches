<?php include '../bdd.php';

if(isset($_GET['id_tache'])){
    $id = $_GET['id_tache'];
    $sql = "DELETE FROM taches WHERE id_tache=$id";
    $conn->query($sql);
    header('Location: ../page/index.php');
}