
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <title>Header</title>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>
        /* Styles de base */
body {
    margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif;
}

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 2rem;
    background-color: #007BFF;
    color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.logo img {
    height: 50px;
    width: auto;
    border-radius: 50%;
}

.menu-toggle {
    display: none;
    font-size: 2rem;
    cursor: pointer;
}

nav#nav-menu {
    display: flex;
    align-items: center;
}

nav#nav-menu ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    gap: 1.5rem;
}

nav#nav-menu ul li {
    display: inline;
}

nav#nav-menu ul li a {
    color: #fff;
    text-decoration: none;
    font-size: 1rem;
    transition: color 0.3s ease;
}

nav#nav-menu ul li a:hover {
    color: #f2b706; /* Couleur au survol */
}

.icons {
    display: flex;
    gap: 1rem;
    font-size: 1.5rem;
}

.icons a {
    color: #fff;
    text-decoration: none;
    transition: color 0.3s ease;
}

.icons a:hover {
    color: #f2b706; /* Couleur au survol */
}

/* Responsive Design */
@media (max-width: 768px) {
    .menu-toggle {
        display: block;
    }

    nav#nav-menu {
        display: none;
        flex-direction: column;
        position: absolute;
        top: 70px;
        right: 1rem;
        background-color: #007BFF;
        padding: 1rem;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    nav#nav-menu ul {
        flex-direction: column;
        gap: 1rem;
    }
    .icons {
        font-size: 1.25rem;
    }
}
    </style>
</head>
<body>

    <header>
        <div class="logo">
            <a href="#"><img src="images/todo1.jpg" alt="logo"></a>
        </div>

        <div class="menu-toggle" onclick="toggleMenu()">
            <ion-icon name="menu-outline"></ion-icon>
        </div>

        <nav id="nav-menu">
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="history.php">Liste des tâches</a></li>
            </ul>
        </nav>

        <div class="icons">
            <a href="notif.php" id="notif-bell">
            <span style="position: relative; display: inline-block;">
                <ion-icon name="notifications-outline"></ion-icon>
                <?php $id = $_SESSION['id_user']; include 'bdd.php';  $sql = "SELECT statut FROM taches WHERE id_user = $id AND statut = 0";
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
    <script>
        if ("serviceWorker" in navigator) {
            navigator.serviceWorker.register("http://127.0.0.1/Gestion_des_taches/service-worker.js")
            .then(() => console.log("Service Worker enregistré !"))
            .catch(err => console.error("Erreur Service Worker :", err));
        }
    </script>
    <script src="alerte.js"></script>

</body>
</html>