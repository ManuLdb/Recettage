<?php
require('config/db.php');
require('config/session.php');
if (isset($_POST['titre']) && !empty($_POST['titre'])

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

<?php
$idauthor = $_SESSION['id_user'];
$variable= $db->query("SELECT titre, author_id FROM recette WHERE author_id = $idauthor" );
while($data =$variable->fetch()){
    ?>
    <br>
    <p class="title">Realisateur : <span class="texte"> <?php echo $data['titre']; ?> </span>            </p>
    <?php
}
$variable->closeCursor();
?>