<?php
require('config/db.php');
if (isset($_POST['pseudo']) && !empty($_POST['pseudo'])
    && isset($_POST['password']) && !empty($_POST['password'])
){ /* stockage des données*/
    $request = $db->prepare('INSERT INTO author (pseudo, password) VALUES(:pseudo,:password)');
    $request->execute(
        array(
            'pseudo'=>$_POST['pseudo'],
            'password'=>$_POST['password']
        )

    );
    /*lien de la redirection*/

};
?>
<form action="register.php" method="post">
    <input type="text" name="pseudo" placeholder="Pseudo" required/>
    <input type="password" name="password" placeholder="Mot de passe" required/>
    <input type="submit" Value="S'inscrire"/>
</form>
