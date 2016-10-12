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
$variable= $db->query("SELECT id, titre, author_id FROM recette WHERE author_id = $idauthor" );
while($data =$variable->fetch()){
    ?>
    <br>
    <a href="recette.php?id=<?php echo $data['id']; ?>"><p> <?php echo $data['titre']; ?> </p></a>
    <?php
}
$variable->closeCursor();
?>