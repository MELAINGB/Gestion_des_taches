<?php include '../bdd.php';
session_start();
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
    <title>Mon espace</title>
    <link rel="stylesheet" href="../style/acompt.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="app-container">
        <h1>Bienvenue sur votre espace personnel</h1>
        
        <!-- Section Profil -->
        <div class="profile">
            <img src="../images/images.png" alt="Photo de profil" class="profile-img">
            <div class="profile-info">
                <p class="profile-name"><?php echo $_SESSION['pseudo']; ?></p>
                <p><?php echo $_SESSION['email']; ?></p>
            </div>
        </div>

        <div>
            <?php include '../bdd.php';
            // Nombres de tâches effectuées
            $sql1 = "SELECT COUNT(*) FROM taches WHERE id_user = $_SESSION[id_user] AND statut = 1";
            $result1 = $conn->query($sql1);
            $row1 = $result1->fetch();
            $taches_effectuees = $row1['COUNT(*)'];
   
            // Nombres de tâches restantes
            $sql2 = "SELECT COUNT(*) FROM taches WHERE id_user = $_SESSION[id_user] AND statut = 0";
            $result2 = $conn->query($sql2);
            $row2 = $result2->fetch();
            $taches_restantes = $row2['COUNT(*)'];

            // Nombres de tâches en retard
            $sql3 = "SELECT COUNT(*) FROM taches WHERE id_user = $_SESSION[id_user] AND statut = 0 AND deadline < NOW()";
            $result3 = $conn->query($sql3);
            $row3 = $result3->fetch();
            $taches_en_retard = $row3['COUNT(*)'];

            ?>
           
        </div>
        <h2>Statistiques</h2>
        <div class="stats">
            
            <div class="card" style="background-color: rgba(0, 128, 0, 0.6) ;">
                <h3>Effectuée(s)</h3>
                <p><?php echo $taches_effectuees; ?></p>
            </div>
            <div class="card"  style="background-color:rgba(255, 187, 0, 0.6);">
                <h3>Restante(s)</h3>
                <p><?php echo $taches_restantes; ?></p>
            </div>
            <div class="card" style="background-color:rgba(252, 3, 3, 0.6);">
                <h3>En retard</h3>
                <p><?php echo $taches_en_retard; ?></p>
            </div>

        </div>

        <!-- Liens rapides -->
        <div class="links">
            <p>Vous pouvez consulter vos tâches ici :</p>
            <a href="history.php" class="btn-link">Mes tâches</a>
        </div>

        <!-- Actions -->
        <div class="actions">
            <a href="#" class="btn-action" onclick="openForm()">Modifier votre mot de passe</a>
            <a href="../php/logout.php" class="btn-action">Se déconnecter</a>
        </div>

        <!-- Formulaire de modification de mot de passe -->
        <div class="form-popup" id="myForm">
            <form action="../php/uppsw.php" method="post" class="form-container">
                <a href="#" class="close" onclick="closeForm()">❌</a> 
                <h2>Modifier votre mot de passe</h2> 
                
                <input type="password" placeholder="Entrez votre actuel mot de passe" name="psw_act" required>            
                <input type="password" placeholder="Entrez votre nouveau mot de passe" name="psw" required>
                <input type="password" placeholder="Confirmez votre nouveau mot de passe" name="psw1" required>

                <button type="submit" class="btn" name="uppsw">Modifier</button>
            </form>
        </div>

        <!-- Overlay -->
        <div class="overlay" id="overlay"></div>
    </div>

    <script>
        function openForm() {
            document.getElementById("myForm").style.display = "block";
            document.getElementById("overlay").style.display = "block";
        }
        function closeForm() {
            document.getElementById("myForm").style.display = "none";
            document.getElementById("overlay").style.display = "none";
        }
    </script>
</body>
</html>