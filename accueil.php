<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>fullPage.js One Page Scroll Sites</title>
    <meta name="author" content="Alvaro Trigo Lopez" />
    <meta name="description" content="fullPage plugin by Alvaro Trigo. Create fullscreen pages fast and simple. One page scroll like iPhone website." />
    <meta name="keywords"  content="fullpage,jquery,alvaro,trigo,plugin,fullscren,screen,full,iphone5,apple" />
    <meta name="Resource-type" content="Document" />

    <link rel="stylesheet" type="text/css" href="css/style.css" />

</head>
<body id="welcome">

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
<div class="form-create">
    <form action="accueil.php" method="post">
        <input style="width: 585px" class="border-input cahier" type="text" name="titre" placeholder="Titre de votre nouveau cahier de recettage ..." required/>
        <br>
        <input class="button-ajout" type="submit" Value="Création de votre cahier des charges"/>
    </form>
</div>
<div class="form-save">Vos Cahiers de Recettage :</div>
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

</body>
</html>

