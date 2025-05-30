<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
    <title>Se Connecter</title>
    <link rel="stylesheet" href="../style/conn.css">
    <script src="../script/script.js"></script>
    <script  type = "module"  src = "https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" > </script> 
    <script  nomodule  src = "https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" > </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  
</head>
<body>

    <div class="wrapper">
        <div class="container main">
            <div class="row">
                <div class="col-md-6 side-image">
                        
                    <!-------------   image     ------------->
                    
                    <div class="text">
                        <p>Je n'oublie plus mes tâches à faire </p>
                    </div>
                    
                </div>

                <div class="col-md-6 right">
                    
                    <div class="input-box">
                    
                    <header>Se Connecter</header>
                    <form action="" method="POST">
                            <div class="input-field">
                                    <input type="text" class="input" id="email" name="email" required>
                                    <label for="email">Email</label> 
                                </div> 
                            <div class="input-field">
                                    <input type="password" class="input" id="pass" name="password" onclick="togglePassword()" required>
                                    <label for="pass">Mot de passe </label>
                                </div> 
                            <div class="input-field">
                                    
                                    <input type="submit" class="submit" name="connexion" value="Se connecter">
                            </div> 
                            <div class="signin">
                                <span>Vous n'avez pas de compte? <a href="ins.php">Inscrivez-vous</a></span><br>
                                <span><a href="mdpfgt.php">Mot de passe oublie?</a></span>                            
                            </div>

                        </form>

                        <?php
                        include '../bdd.php';

                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
                            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
                        
                            // Récupération des données de l'utilisateur
                            $sql = "SELECT * FROM utilisateurs WHERE email = :email";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute(['email' => $email]);
                            $user = $stmt->fetch();

                            // Vérification des données de l'utilisateur

                            if ($stmt->rowCount()==1) {

                                if (password_verify($password, $user['password'])) {

                                    session_start();
                                    $_SESSION['email'] = $user['email'];
                                    $_SESSION['id_user'] = $user['id_user'];
                                    $_SESSION['pseudo'] = $user['pseudo'];
                                    header('Location: index.php');
                                                                        
                                } else {
                                   echo "<h5>Email incorrect/ utilisateur introuvable.</h5>";
                                }
                                
                            }else{
                                echo "<h5>Email incorrect/ utilisateur introuvable.</h5>";
                            }
    
                        }

                        ?>

                    </div>  
                </div>
            </div>
        </div>
    </div>
        
</body>
</html>