<?php
session_start();
if(!isset($_SESSION['email'])){
    header('Location: ../page/conn.php');
}

include '../bdd.php';

if(isset($_POST['uppsw'])){
    $psw_act=filter_input(INPUT_POST, 'psw_act', FILTER_SANITIZE_STRING);
    $psw=filter_input(INPUT_POST, 'psw', FILTER_SANITIZE_STRING);
    $pswc=filter_input(INPUT_POST, 'psw1', FILTER_SANITIZE_STRING);
    $id_user = $_SESSION['id_user'];

    $sql = "SELECT * FROM utilisateurs WHERE id_user = $id_user";
    $result = $conn->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);

   
    if ($result->rowCount() == 1) {
      
        if (password_verify($psw_act, $row['password'])) {
            if ($psw == $pswc) {
                $psw = password_hash($psw, PASSWORD_DEFAULT);
                $sql = "UPDATE utilisateurs SET password = '$psw' WHERE id_user = $id_user";
                $conn->query($sql);
                echo "<h4>Mot de passe mis à jour avec success !</h4>";
                echo "<script>
                    setTimeout(function() {window.location.href = '../page/compte.php'; }, 2000); // 2000 millisecondes = 2 s
                    </script>";
            } else {
                echo " <h4>Les mots de passe ne correspondent pas</h4>";
            }
        } else {
            echo " <h4>Mot de passe actuel incorrect </h4>";
        }
    }else{
        echo " <h4>Quelque chose s'est mal passée</h4>";
    }
}else{
    echo " <h4>Quelque chose s'est mal passée</h4>";
}

?>
<script>
    setTimeout(function() {
      window.location.href = "../page/compte.php"; 
    }, 2000); // 2000 millisecondes = 2 secondes
</script>

