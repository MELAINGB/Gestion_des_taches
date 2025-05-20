<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser votre mot de passe</title>
    <link rel="stylesheet" href="conn.css">
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
                       
                        <i style="color: red;">Cet option est indisponible pour le moment</i>
                        <header>Réinitialiser mon mot de passe</header>
                        <i>Bonjour Xxxx</i> <br><br>
                    
                        <form action="" method="POST">
                            <div class="input-field">
                                <input type="text" class="input" id="email" name="email" required>
                                <label for="email">Mode de passe</label> 
                            </div> 
                            <div class="input-field">
                                <input type="text" class="input" id="email" name="email" required>
                                <label for="email">Confirmer le mot de passe</label> 
                            </div> 

                            <div class="input-field">
                                <input type="submit" class="submit" name="mdp" value="Changer de mot de passe">
                            </div> 
                        </form>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>