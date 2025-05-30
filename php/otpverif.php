<?php 
$code = filter_input(INPUT_POST, 'otp', FILTER_SANITIZE_NUMBER_INT);
echo $code;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>code verif</title>
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
                        
                        <header>Code de verification</header>
                       
                       
                        <!-- <form action="" method="POST">
                            <div class="input-field">
                                <input type="number" class="input" id="code" name="code" required>
                                <label for="code">Code de verification :</label> 
                                <i>Code à 6 chiffres obligatoire</i>
                            </div> 
                            <div class="input-field">
                                <input type="submit" class="submit" name="verif" value="Vérifier" required>
                            </div> 
                        </form> -->
                        <?php
                       
                        
                        // if(isset($_POST['verif'])){
                        //     echo $code;
                        //     // Vérification du code OTP
                        //     $usercode = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_NUMBER_INT);
                        //     if($code == $usercode){
                        //         echo '<h5>Code vérifié avec succès !</h5>';
                        //         // Redirection vers la page de réinitialisation du mot de passe
                        //         echo "je marche";
                        //     } else {
                        //         echo '<h5>Code incorrect, veuillez réessayer.</h5>';
                        //     }
                        // }else {
                        //     echo '<h5>Veuillez entrer le code de vérification envoyé à votre adresse e-mail.</h5>';
                        // }
                        
                        
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
</body>
</html>