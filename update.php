<?php include 'bdd.php';
if(isset($_POST['update_task']))
{
    
    $idt= htmlspecialchars($_POST['id_tache']);
    $titre= htmlspecialchars($_POST['titre']);
    $des= htmlspecialchars($_POST['des']);
    $deadline = htmlspecialchars($_POST['deadline']);


    $sql = "UPDATE taches SET titre = :titre, description = :des, deadline = :deadline WHERE id_tache = :idt";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':des', $des);
    $stmt->bindParam(':idt', $idt);
    $stmt->bindParam(':deadline', $deadline);
    
    if ($stmt->execute()) {
        echo "Information de $titre mise à jour avec succès!";
        header ('location: index.php');
        
    } else {
        echo "Erreur de mise à jour";
    }

}else{
    echo "Quelque chose s'est mal passée";
}
?>