<?php include 'bdd.php';
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
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <title>Mon espace</title>
    <style>
        /* Styles de base */
body {
    font-family: 'times new roman', Times, serif, sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 0;
    color: #333;
}

.app-container {
    max-width: 800px;
    margin: 2rem auto;
    padding: 1.5rem;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    margin-bottom: 1.5rem;
}

/* Section Profil */
.profile {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
}

.profile-img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #007BFF;
}

.profile-info {
    display: flex;
    flex-direction: column;
    
}

.profile-name {
    font-size: 1.25rem;
    font-weight: bold;
    color: #007BFF;
}


/* Liens rapides */
.links {
    text-align: center;
    margin-bottom: 2rem;
}

.links p {
    font-size: 1rem;
    color: #555;
    margin-bottom: 0.5rem;
}

.btn-link {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    background-color: #007BFF;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    font-size: 1rem;
    transition: background-color 0.3s ease;
}

.btn-link:hover {
    background-color: #0056b3;
}

/* Actions */
.actions {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 2rem;
}

.btn-action {
    padding: 0.75rem 1.5rem;
    background-color: #f4f4f9;
    color: #007BFF;
    text-decoration: none;
    border: 1px solid #007BFF;
    border-radius: 5px;
    font-size: 1rem;
    text-align: center;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.btn-action:hover {
    background-color: #007BFF;
    color: #fff;
}

/* Formulaire de modification de mot de passe */
.form-popup {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1000;
    background-color: #fff;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    width: 90%;
    max-width: 400px;
}

.form-container {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.form-container h2 {
    text-align: center;
    color: #007BFF;
    margin-bottom: 1rem;
}

.form-container input {
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1rem;
}

.form-container .btn {
    padding: 0.75rem;
    background-color: #007BFF;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.form-container .btn:hover {
    background-color: #0056b3;
}

.close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    font-size: 1.25rem;
    color: #333;
    cursor: pointer;
    text-decoration: none;
}

/* Overlay */
.overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 999;
}

/* Statistiques */
.stats {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 2rem;
}
.card {
    
    padding: 0.5rem;
    background-color:rgba(252, 3, 3, 0.64);
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    flex: 1;
    text-align: center;
}

.card p {
    font-size: 1rem;
    font-weight: bold;
}

/* Responsive Design */
@media (max-width: 768px) {
    .app-container {
        padding: 1rem;
        max-width: 100%;
        margin: 0;
        border-radius: 0;
    }

    .profile {
        flex-direction: column;
        text-align: center;
    }
    .stats {
        flex-direction: column;
        gap: 1rem;
    }
    
}
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="app-container">
        <h1>Bienvenue sur votre espace personnel</h1>
        
        <!-- Section Profil -->
        <div class="profile">
            <img src="images/images.png" alt="Photo de profil" class="profile-img">
            <div class="profile-info">
                <p class="profile-name"><?php echo $_SESSION['pseudo']; ?></p>
                <p><?php echo $_SESSION['email']; ?></p>
            </div>
        </div>

        <div>
            <?php include 'bdd.php';
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
            <a href="logout.php" class="btn-action">Se déconnecter</a>
        </div>

        <!-- Formulaire de modification de mot de passe -->
        <div class="form-popup" id="myForm">
            <form action="uppsw.php" method="post" class="form-container">
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