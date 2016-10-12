<?php
require('config/db.php');
if (isset($_POST['pseudo']) && !empty($_POST['pseudo'])
    && isset($_POST['password']) && !empty($_POST['password'])
    ) {
    $reponse = $db->query('SELECT pseudo FROM author WHERE pseudo="'.$_POST['pseudo'].'"');
    if ($donnees = $reponse->fetch()) {
            echo 'erreur pseudo déjà enregistré';
        } else {
        /* stockage des données*/
        $request = $db->prepare('INSERT INTO author (pseudo, password) VALUES(:pseudo,:password)');
        $request->execute(
            array(
                'pseudo'=>$_POST['pseudo'],
                'password'=>$_POST['password']
            )

        );
        header('Location:login.php');
    }
        };


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inscription</title>


    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script src="js/modernizr.custom.63321.js"></script>

</head>
<body>
<div class="container">
    <header>
        <h1 class="titre"><strong>Project Memories</strong></h1>
        <h2 class="sous-titre">Inscrivez votre équipe projet</h2>
    </header>
    <section class="main">
        <form action="register.php" method="post" class="form-1">
            <p class="field">
                <input type="text" name="pseudo" placeholder="Pseudo" required/>
                <i class="icon-user icon-large"></i>
            </p>
            <p class="field">
                <input type="password" name="password" placeholder="Mot de passe" required/>
                <i class="icon-lock icon-large"></i>
            </p>
            <p class="submit">
                <button type="submit" name="submit"><i class="icon-arrow-right icon-large"></i></button>
            </p>
        </form>
    </section>
    <footer>
        <h2><strong>Déjà inscrit ? cliquez sur le boutton ci-dessous</strong></h2>
        <section>
            <div id="container_buttons">
                <p>
                    <a class="a_demo_five" href="login.php">
                        CONNEXION
                    </a>
                </p>
            </div>
        </section>
    </footer>
</div>
</body>
</html>
