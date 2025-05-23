<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublie</title>
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
                        <p>Entrez votre email</p>
                       
                        <form action="" method="POST">
                            <div class="input-field">
                                <input type="text" class="input" id="email" name="email" required>
                                <label for="email">Email</label> 
                            </div> 
                            <div class="input-field">
                                <input type="submit" class="submit" name="mdp" value="Réinitialiser">
                            </div> 
                        </form>
                        <?php
                        include '../bdd.php';
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

                            $sql = "SELECT * FROM utilisateurs WHERE email = :email";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute([':email'=> $email]);
                            $info = $stmt->fetch();

                            if ($stmt->rowCount() == 0) {
                                echo '<h5>Aucun compte n\'est associé à cet email</h5>';
                            }else{
                                if ($email) {
                                    $to = $email;
                                    $subject = "Réinitialisation de mot de passe";
                                    $message = "Cliquez sur le lien suivant pour réinitialiser votre mot de passe : <a href='http://example.com/reset_password.php?token=your_token'>Réinitialiser</a>";
                                    $headers = "From: melaingb@gmail.com\r\n";
                                    $headers .= "MIME-Version: 1.0\r\n";
                                    if (mail($to, $subject, $message, $headers)) {
                                        echo '<h5>Un email de réinitialisation a été envoyé à votre adresse</h5>';
                                    } else {
                                        echo '<h5>Erreur lors de l\'envoi de l\'email : contactez nous!</h5>';
                                    }

                                } else {
                                    echo '<h5>Veuillez entrer votre email valide </h5>';
                                }
                                
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