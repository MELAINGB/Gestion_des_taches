<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
    <title>S'incrire</title>
    <link rel="stylesheet" href="../style/conn.css">
    <script src="../script/script.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

    <div class="wrapper">
        <div class="container main">
            <div class="row">   
               
                <div class="col-md-6 right">
                    
                    <div class="input-box">
                    
                    <header>S'incrire</header>
                    <form action="" method="POST">

                            <div class="input-field">
                                <input type="text" class="input" id="nom" name="nom" required>
                                <label for="nom">Pseudo</label>
                            </div>

                            <div class="input-field">
                                <input type="text" class="input" id="email" name="email" required>
                                <label for="email">Email</label> 
                            </div> 

                            <div class="input-field">
                                <input type="password" class="input" id="pass" name="password" onclick="togglePassword()" required>
                                <label for="pass">Mot de passe</label>
                            </div>
                            
                            <div class="input-field">
                                <input type="password" class="input" id="pass" name="password1" onclick="togglePassword()" required>
                                <label for="pass">Confirmer le mot de passe</label>
                            </div>

                            <div class="input-field">
                                    
                                <input type="submit" class="submit" name="connexion" value="S'inscrire">
                            </div> 

                            <!-- <div class="signin">
                                <span>Vous avez déjà un compte? <a href="conn.php">connectez-vous</a></span>
                            </div> -->

                        </form>

                        <?php include("../bdd.php");

                            if (isset($_POST["connexion"])){
                                $pseudo = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
                                $email =   filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
                                $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
                                $password1 = filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_SPECIAL_CHARS);
                                
                                if (!empty($pseudo && $email && $password && $password1)) {
                                    if($password == $password1){

                                        $pwd_password = password_hash($password, PASSWORD_DEFAULT);

                                        $requete = $conn->prepare('SELECT * FROM utilisateurs WHERE email=?');
                                        $requete->execute(array($email));

                                        if($requete->rowCount()>0){
                                            echo "<h5>Cette adresse email est déjà utilisé</h5>";
                                            ?><div class="signin">
                                                 <span>Vous avez déjà un compte? <a href="conn.php">connectez-vous</a></span>
                                                </div>
                                            <?php

                                        }else{
                                            // vérification du mail
                                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                                echo "<h5>Adresse email invalide</h5>";
                                            }else{
                                                $to = $email;
                                                $subject = "Confirmation de votre mail ";
                                                $message = "Bonjour $pseudo,\n
                                                Votre inscription sur notre application de gestion de tâche a été réussie.\n\n 
                                                Cliquez ici pour vous connectez!\n\n : " ?><a href="https://melain.alwaysdata.net/gt/page/conn.php"> Se connecter </a> <?php "\n\n
                                                Cordialement,\n\n
                                                L'equipe de GT de Melain 😊";
                                                $headers = "From: melainbigmangbaguidi@gmail.com\r\n";
                                                
                                                if(mail($to, $subject, $message, $headers)){
                                                    echo "<h4 style='font-size: 18px;'>Un email a été envoyé à $email</h4>";
                                                }else{
                                                    echo "<h5>Erreur lors de l'envoi de l'email : contactez nous!</h5>";
                                                }
                                            }
                                                
                                                $requete = $conn->prepare('INSERT INTO utilisateurs (email, pseudo, password) VALUES (?, ?, ?)');
                                                $requete->execute(array($email,$pseudo, $pwd_password));
                                                echo "<h4 style='font-size: 18px;'>Inscription reussie!</h4>";
                                        }
                                    }else{
                                        echo "<h5>Les mots de passe ne correspondent pas </h5>";
                                    }
                                }else{
                                    echo "<h5>Veuillez remplir tous les champs</h5>";
                                }
                            }

                        ?>

                    </div>  
                </div>

                <div class="col-md-6 side-image">
                        
                    <!-------------      image     ------------->
                    
                    <div class="text">
                        <p>Je n'oublie plus mes choses à faire</p>
                    </div>
                        
                </div>

            </div>
        </div>
    </div>
        
</body>
</html>
