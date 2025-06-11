<?php include '../bdd.php';
// Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
if(!isset($_SESSION['email'])){
    header('Location: conn.php');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
    <title>Header</title>
    <link rel="stylesheet" href="../style/head.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!-- Inclure le fihcier de push -->
     <script src="push.js"></script>
  
</head>
<body>

    <header>
        <!-- <div class="logo">
            <a href="#"><img src="../images/todo1.jpg" alt="logo"></a>
        </div> -->
         
        <div class="menu-toggle" onclick="toggleMenu()">
            <ion-icon name="grid-outline" ></ion-icon>
        </div>
        
            <nav id="nav-menu">
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="history.php">Liste des tâches</a></li>
                    <li><a href="groups.php">Groupes</a></li>
                </ul>
            </nav>
            <p class="header-alert"> <i>Toujours à jour dans mes tâches.</i></p>
        
            <div class="icons">
                <a href="notif.php" id="notif-bell">
                <span style="position: relative; display: inline-block;">
                    <ion-icon name="notifications-outline"></ion-icon>
                    <?php 
                    $id = $_SESSION['id_user']; include '../bdd.php';  $sql = "SELECT statut FROM taches WHERE id_user = $id AND statut = 0";
                    $result = $conn->query($sql);
                    $result->setFetchMode(PDO::FETCH_ASSOC);
                    if($result->rowCount() > 0){?><span style="
                        position: absolute;
                        top: 1px;
                        right: 2px;
                        width: 5px;
                        height: 5px;
                        background: #f44336;
                        border-radius: 50%;
                        border: 2px solid #fff;
                        display: inline-block;
                        ">
                    </span><?php }
                ?>
                    
                </span>
                <a href="compte.php"><ion-icon name="person-circle-outline"></ion-icon></a>
            </div>
        
        
    </header>

    <script>
        function toggleMenu() {
            var navMenu = document.getElementById('nav-menu');
            if (navMenu.style.display === 'flex') {
                navMenu.style.display = 'none';
            } else {
                navMenu.style.display = 'flex';
            }
        }
    </script>

    <script src="../script/script.js"></script>

</body>
</html>