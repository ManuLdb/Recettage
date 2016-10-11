<?php
require('config/db.php');

if (isset($_POST['titre']) && !empty($_POST['titre'])
    && isset($_SESSION['id_user']) 

){ /* stockage des données*/
    $request = $db->prepare('INSERT INTO recette (titre, author_id) VALUES(:titre, :author_id)');
    $request->execute(
        array(
            'titre'=>$_POST['titre'],
            'author_id'=>$_SESSION['id_user']
        )

    );
    /*lien de la redirection*/

};

?>
<form action="accueil.php" method="post">
    <input type="text" name="titre" placeholder="Titre du cahier" required/>
    <input type="submit" Value="Connexion"/>
</form>