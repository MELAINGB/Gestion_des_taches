<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser votre mot de passe</title>
    <link rel="stylesheet" href="../style/conn.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    <div class="wrapper">
        <div class="container main">
            <div class="row">
                <div class="col-md-6 side-image">
                    <div class="text">
                        <p>Je n'oublie plus mes tâches à faire </p>
                    </div>
                </div>
                <div class="col-md-6 right">
                    <div class="input-box">
                    
                        <header>Réinitialiser mon mot de passe</header>
                        <i>Bonjour, </i> <br><br>
                    
                        <form action="" method="POST">
                            <div class="input-field">
                                <input type="text" class="input" id="email" name="mdp" onclick="togglePassword()" required>
                                <label for="email">Mode de passe</label> 
                            </div> 
                            <div class="input-field">
                                <input type="text" class="input" id="email" name="mdp1" onclick="togglePassword()" required>
                                <label for="email">Confirmer le mot de passe</label> 
                            </div> 

                            <div class="input-field">
                                <input type="submit" class="submit" name="change" value="Changer de mot de passe">
                            </div> 
                        </form>
                       
                    </div>
                </div>
                <?php 
                include '../bdd.php';

                $token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_SPECIAL_CHARS);
                if ($token){

                    $email = openssl_decrypt(
                    base64_decode($token),
                    'AES-128-CTR',
                    'votre_cle_secrete',
                    0,
                    '1234567891011121'
                    );

                    if(isset($_POST['change'])){
                        $new_password = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_SPECIAL_CHARS);
                        $confirm_password = filter_input(INPUT_POST, 'mdp1', FILTER_SANITIZE_SPECIAL_CHARS);

                        if ($new_password === $confirm_password) {
                            // Mettre à jour le mot de passe dans la base de données
                            $has_password = password_hash($new_password, PASSWORD_DEFAULT);
                            
                            $sql = "UPDATE utilisateurs SET password = :password WHERE email = :email";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute([':password' => $has_password, ':email' => $email]);

                            echo '<h5 style = "color: green;" >Mot de passe mis à jour avec succès ! Veuillez vous reconnecter <a href="conn.php" >ici</a></h5>';
                        } else {
                            echo '<h5>Les mots de passe ne correspondent pas.</h5>';
                        }
                    }

                }else{
                    echo '<h5>Erreur de réinitialisation de mot de passe! Réessayez!</h5>';
                }

                ?>
            </div>
        </div>
    </div>
    
</body>
</html>