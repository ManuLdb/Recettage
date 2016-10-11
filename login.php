<?php
require('config/db.php');
session_start();
if (isset($_POST['pseudo']) && !empty($_POST['pseudo'])
    && isset($_POST['password']) && !empty($_POST['password'])) {
    session_unset();
    $request = $db->prepare('SELECT id, pseudo, password FROM author WHERE pseudo = :pseudo');
    $request->execute(
        array(
            'pseudo' => $_POST['pseudo']
        )
    );
    while ($data = $request->fetch()) {
        if ($data['password'] == $_POST['password']) {
            session_start();
            $_SESSION['id_user'] = $data['id'];
            $_SESSION['pseudo_user'] = $data['pseudo'];
            header('Location:accueil.php');
        }
    }
}

?>
<form action="login.php" method="post">
    <input type="text" name="pseudo" placeholder="Pseudo" required/>
    <input type="password" name="password" placeholder="Mot de passe" required/>
    <input type="submit" Value="Connexion"/>
</form>
