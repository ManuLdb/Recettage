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
<form action="register.php" method="post">
    <input type="text" name="pseudo" placeholder="Pseudo" required/>
    <input type="password" name="password" placeholder="Mot de passe" required/>
    <input type="submit" Value="S'inscrire"/>
</form>
