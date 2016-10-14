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
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<ul class="menu">
    <li><a style="font-weight: bold;text-decoration: underline" class="js-scrollTo" href="accueil.php">ACCUEIL</a></li>
    <li><a class="js-scrollTo cool-link" href="#page-1">Logo/Nom Entreprise</a></li>
    <li><a class="js-scrollTo cool-link" href="#page-2">Pitch/Brief</a></li>
    <li><a class="js-scrollTo cool-link" href="#page-3">Objectifs</a></li>
    <li><a class="js-scrollTo cool-link" href="#page-4">L'Equipe</a></li>
    <li><a class="js-scrollTo cool-link" href="#page-5">Process</a></li>
    <li><a class="js-scrollTo cool-link" href="#page-6">Organisation</a></li>
    <li><a class="js-scrollTo cool-link" href="#page-7">Risques/Solutions</a></li>
    <li><a class="js-scrollTo cool-link" href="#page-8">Matrice</a></li>
    <li><a class="js-scrollTo cool-link" href="#page-9">Feuille Recettage</a></li>
</ul>

<div id="formulaire">
<?php
require("config/db.php");
session_start();
$id=$_GET["id"];
if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);


    $variable = $db->prepare("SELECT id,titre FROM recette WHERE id=:id");
    $variable->execute(
        array(
            'id' => $id
        )
    );
    while ($data = $variable->fetch()) {
        ?>
        <p> <?php echo $data['titre']; ?> </p>
        <?php
    }
}
?>
    <div class="section" id="page-1">
        <div class="titre">Logo et Nom de votre entreprise :</div>
        <form action="recette.php?id=<?php echo $id ?>" method="post" enctype="multipart/form-data">
            <input style="width: 410px" class="border-input" type="text" name="name" placeholder="Indiquez le titre de votre logo ..." />
            <br>
            <input type="file" name="image" placeholder="image" />
            <br>
            <input class="button-add" type="submit" value="Ajouter le logo"/>
        </form>

<?php
$error = "";
if ($_FILES['image']['error'] > 0){
    $error = "Erreur lors du transfert";
}
// verification de la taille de l'image
$maxsize = 10000000;
if($_FILES['image']['size'] > $maxsize){
    $error = "Le fichier est trop gros";
}
//verification de l'extension de l'image
$accepted_extensions = array('jpg', 'jpeg', 'gif', 'png');
$name_exploded = explode('.', $_FILES['image']['name']);
$file_extension = strtolower($name_exploded[sizeof($name_exploded)-1]);
// On verifie si l'extension du fichier est dans les acceptées
if (!in_array($file_extension, $accepted_extensions)){

}
if ($error ==''){


$filepath ='uploads/'.time().'.'.$file_extension;
$result = move_uploaded_file($_FILES['image']['tmp_name'], $filepath);
if ($result){
echo "Merci pour l'image";


$req = $db->prepare('INSERT INTO image (path, name, recette_id) VALUES(:path, :name,:recette_id)');
$req->execute(array(
'path' => $filepath,
'name' => $_POST['name'],
'recette_id'=>$id
));
$req->closeCursor();
echo ""; //affichage
}
else {

}
}
else{
echo $error;
}
$req = $db->prepare("SELECT path FROM image");
$req->execute(array());
$donnees = $req->fetch();
// On affiche l'image
?>

        <img src="<?php echo $donnees['path']; ?>">
        <a href="suppressionimage.php?id=<?php echo $data['id']; ?>"><img src="img/delete.png" alt="delete" class="delete"></a>
        <!--Ajout nom entreprise-->
        <form action="recette.php?id=<?php echo $id ?>" method="post">
            <input style="width: 490px" class="border-input name-entreprise" type="text" name="titre" placeholder="Indiquez le nom de votre entreprise ..." />
            <br>
            <input type="submit" class="button-add" value="Ajouter le nom de l'entreprise"/>
        </form>
    </div>
<?php
if (isset($_POST['titre']) && !empty($_POST['titre'])
) {
        /* stockage des données*/
        $request = $db->prepare('INSERT INTO entreprise(titre, recette_id) VALUES(:titre, :recette_id)');
        $request->execute(
            array(
                'titre'=>$_POST['titre'],
                'recette_id'=>$id

            )

        );
};
$variable= $db->query("SELECT id, titre FROM entreprise" );
while($data =$variable->fetch()){
?>

<p><?php echo $data['titre'];?></p>
    <a href="suppressionentreprise.php?id=<?php echo $data['id']; ?>"><img src="img/delete.png" alt="delete" class="delete"></a>
<?php
}

$variable->closeCursor();
?>



<!--Ajout Pitch-->
    <div class="section color"  id="page-2">
        <div class="titre">Votre Pitch ou Brief :</div>
        <form action="recette.php?id=<?php echo $id ?>" method="post">
             <textarea name="pitch" rows="10" cols="50" placeholder="Décrivez votre pitch ..."></textarea><br>
            <input class="button-add" type="submit" value="Ajouter votre pitch"/>
        </form>
<?php
if (isset($_POST['pitch']) && !empty($_POST['pitch'])
) {
    /* stockage des données*/
    $request = $db->prepare('INSERT INTO pitch(titre, recette_id) VALUES(:titre, :recette_id)');
    $request->execute(
        array(
            'titre'=>$_POST['pitch'],
            'recette_id'=>$id

        )

    );
};
$variable= $db->query("SELECT id, titre FROM pitch" );
while($data =$variable->fetch()){
    ?>

    <p><?php echo $data['titre'];?>
        <a href="suppressionpitch.php?id=<?php echo $data['id']; ?>"><img src="img/delete.png" alt="delete" class="delete"></a>
    <?php
}

$variable->closeCursor();
?>
    <!--Ajout brief-->
        <form action="recette.php?id=<?php echo $id ?>" method="post">
             <textarea name="brief" rows="10" cols="50" placeholder="Décrivez votre brief ..."></textarea><br>
            <input class="button-add" type="submit" value="Ajouter votre brief"/>
        </form>

<?php
if (isset($_POST['brief']) && !empty($_POST['brief'])
) {
    /* stockage des données*/
    $request = $db->prepare('INSERT INTO brief(titre, recette_id) VALUES(:titre, :recette_id)');
    $request->execute(
        array(
            'titre'=>$_POST['brief'],
            'recette_id'=>$id

        )

    );
};
$variable= $db->query("SELECT id, titre FROM brief" );
while($data =$variable->fetch()){
    ?>

    <p><?php echo $data['titre'];?></p>
    <a href="suppressionbrief.php?id=<?php echo $data['id']; ?>"><img src="img/delete.png" alt="delete" class="delete"></a>
    <?php
}

$variable->closeCursor();
?></div>
<!--Ajout Smart-->
    <div class="section"  id="page-3">
        <div class="titre">Vos Objectifs SMART :</div>
        <form action="recette.php?id=<?php echo $id ?>" method="post">
             <textarea name="smart" rows="10" cols="50" placeholder="Décrivez vos objectifs smart ..."></textarea>
            <br>
            <input class="button-add" type="submit" value="Ajouter vos objectifs smart"/>
        </form>
    </div>
<?php
if (isset($_POST['smart']) && !empty($_POST['smart'])
) {
    /* stockage des données*/
    $request = $db->prepare('INSERT INTO smart(titre, recette_id) VALUES(:titre, :recette_id)');
    $request->execute(
        array(
            'titre'=>$_POST['smart'],
            'recette_id'=>$id

        )

    );
};
$variable= $db->query("SELECT id, titre FROM smart" );
while($data =$variable->fetch()){
    ?>

    <p><?php echo $data['titre'];?></p>
    <a href="suppressionsmart.php?id=<?php echo $data['id']; ?>"><img src="img/delete.png" alt="delete" class="delete"></a>
    <?php
}

$variable->closeCursor();
?>
<!--Ajout Equipe-->
    <div class="section color"  id="page-4">
        <div class="titre">Votre Equipe :</div>
        <form action="recette.php?id=<?php echo $id ?>" method="post">
            <textarea name="equipe" rows="10" cols="50" placeholder="Indiquez votre équipe ..."></textarea>
            <br>
            <input class="button-add" type="submit" value="Ajouter votre équipe"/>
        </form>

<?php
if (isset($_POST['equipe']) && !empty($_POST['equipe'])
) {
    /* stockage des données*/
    $request = $db->prepare('INSERT INTO equipe(titre, recette_id) VALUES(:titre, :recette_id)');
    $request->execute(
        array(
            'titre'=>$_POST['equipe'],
            'recette_id'=>$id

        )

    );
};
$variable= $db->query("SELECT id, titre FROM equipe" );
while($data =$variable->fetch()){
    ?>

    <p><?php echo $data['titre'];?></p>
    <a href="suppressionequipe.php?id=<?php echo $data['id']; ?>"><img src="img/delete.png" alt="delete" class="delete"></a>
    <?php
}

$variable->closeCursor();
?>
    </div>
    <!--Ajout process-->
    <div class="section"  id="page-5">
        <div class="titre">Votre Process :</div>
        <form action="recette.php?id=<?php echo $id ?>" method="post">
            <input style="width: 330px" class="border-input" type="text" name="process" placeholder="Indiquez votre process ..." />
            <br>
            <input class="button-add" type="submit" value="Ajouter votre process"/>
        </form>
<?php
if (isset($_POST['process']) && !empty($_POST['process'])
) {
    /* stockage des données*/
    $request = $db->prepare('INSERT INTO process(titre, recette_id) VALUES(:titre, :recette_id)');
    $request->execute(
        array(
            'titre'=>$_POST['process'],
            'recette_id'=>$id

        )

    );
};
$variable= $db->query("SELECT id, titre, bool FROM process" );
while($data =$variable->fetch()){
    ?>
    <p><?php echo $data['titre'];echo ' '; echo $data['bool'];?></p>
        <a href="suppressionprocess.php?id=<?php echo $data['id']; ?>"><img src="img/delete.png" alt="delete" class="delete"></a>
        <form action="recette.php?id=<?php echo $id ?>" method="post">Validé<input type="radio" name="bool" value="Oui" >Non validé<input type="radio" name="bool" value="Non" checked>
            <br>
            <input class="button-add" type="submit" value="Envoyez la validation"/>
        </form>
    </div>
    <?php
}
if (isset($_POST['bool']) && !empty($_POST['bool'])
) {
    /* stockage des données*/
    $update = $db->prepare("UPDATE process SET bool=:bool");
    $update->execute(
        array(
            'bool'=>$_POST['bool']

        )
    );
};
$variable->closeCursor();
?>
    <div class="section color"  id="page-6">
        <div class="titre">Vos Organisation du Projet :</div>
        <form action="recette.php?id=<?php echo $id ?>" method="post" enctype="multipart/form-data">
            <input style="width: 470px" class="border-input" type="text" name="nom" placeholder="Indiquez le titre de votre planning ..." />
            <br>
            <input type="file" name="gant" placeholder="image" />
            <br>
            <input class="button-add" type="submit" value="Ajouter votre planning Gannt"/>
        </form>
<?php
$error = "";
if ($_FILES['gant']['error'] > 0){
    $error = "Erreur lors du transfert";
}
// verification de la taille de l'image
$maxsize = 10000000;
if($_FILES['gant']['size'] > $maxsize){
    $error = "Le fichier est trop gros";
}
//verification de l'extension de l'image
$accepted_extensions = array('jpg', 'jpeg', 'gif', 'png');
$name_exploded = explode('.', $_FILES['gant']['name']);
$file_extension = strtolower($name_exploded[sizeof($name_exploded)-1]);
// On verifie si l'extension du fichier est dans les acceptées
if (!in_array($file_extension, $accepted_extensions)){

}
if ($error ==''){


    $filepath ='gantts/'.time().'.'.$file_extension;
    $result = move_uploaded_file($_FILES['gant']['tmp_name'], $filepath);
    if ($result){
        echo "Merci pour l'image";


        $req = $db->prepare('INSERT INTO gantt (chemin, nom, recette_id) VALUES(:chemin, :nom,:recette_id)');
        $req->execute(array(
            'chemin' => $filepath,
            'nom' => $_POST['nom'],
            'recette_id'=>$id
        ));
        $req->closeCursor();
        echo ""; //affichage
    }
    else {

    }
}
else{
    echo $error;
}
$req = $db->prepare("SELECT chemin FROM gantt");
$req->execute(array());
$donnees = $req->fetch();
// On affiche l'image
?>
<img src="<?php echo $donnees['chemin']; ?>">
        <a href="suppressiongant.php?id=<?php echo $data['id']; ?>"><img src="img/delete.png" alt="delete" class="delete"></a>


    <!--Ajout Reunion-->
<?php
    $variable= $db->query("SELECT id, resume, date, recette_id FROM reunion WHERE recette_id = '$id'" );
    while($data =$variable->fetch()){
    ?>

        <p><?php echo $data['date'];?></p>
    <p><?php echo $data['resume'];?></p>
        <a href="suppressionreu.php?id=<?php echo $data['id']; ?>"><img src="img/delete.png" alt="delete" class="delete"></a>



        <?php
}

$variable->closeCursor();
?>
        <form action="recette.php?id=<?php echo $id ?>" method="post">
            <input style="width: 260px" class="border-input input-date" type="date" name="date">
            <br>
            <br>
            <textarea name="resume" rows="10" cols="50" placeholder="Décrivez l'objet de la réunion ..."></textarea>
            <br>
            <input class="button-add" type="submit" value="Ajouter la réunion"/>
        </form>
<?php
if (isset($_POST['resume']) && !empty($_POST['resume'])
    && ($_POST['date']) && !empty($_POST['resume'])
) {
    /* stockage des données*/
    $request = $db->prepare('INSERT INTO reunion(resume, date, recette_id) VALUES(:titre, :date, :recette_id)');
    $request->execute(
        array(
            'titre'=>$_POST['resume'],
            'date'=>$_POST['date'],
            'recette_id'=>$id

        )

    );
};
?>
<!--Ajout motdepasse-->
        <form action="recette.php?id=<?php echo $id ?>" method="post">
             <textarea name="mdp" placeholder="Indiquez les mots de passe ..."></textarea>
            <br>
            <input class="button-add" type="submit" value="Ajouter les mots de passe"/>
        </form>

<?php
if (isset($_POST['mdp']) && !empty($_POST['mdp'])
) {
    /* stockage des données*/
    $request = $db->prepare('INSERT INTO mdp (name, recette_id) VALUES(:name, :recette_id)');
    $request->execute(
        array(
            'name'=>$_POST['mdp'],
            'recette_id'=>$id

        )

    );
};
$variable= $db->query("SELECT id, name FROM mdp" );
while($data =$variable->fetch()){
    ?>

    <p><?php echo $data['name'];?></p>
    <a href="suppressionmdp.php?id=<?php echo $data['id']; ?>"><img src="img/delete.png" alt="delete" class="delete"></a>
    <?php
}

$variable->closeCursor();
?>
    </p>
<!--Ajout Risque-->
    <div class="section"  id="page-7">
        <div class="titre">Les risques et solutions possibles du Projet :</div>
        <form action="recette.php?id=<?php echo $id ?>" method="post">
             <textarea  name="risque" rows="10" cols="50" placeholder="Décrivez les risques ..."></textarea>
            <br>
            <input class="button-add" type="submit" value="Ajouter les risques"/>
        </form>

<?php
if (isset($_POST['risque']) && !empty($_POST['risque'])
) {
    /* stockage des données*/
    $request = $db->prepare('INSERT INTO risque(name, recette_id) VALUES(:name, :recette_id)');
    $request->execute(
        array(
            'name'=>$_POST['risque'],
            'recette_id'=>$id

        )

    );
};
$variable= $db->query("SELECT id, name FROM risque" );
while($data =$variable->fetch()){
    ?>

    <p><?php echo $data['name'];?></p>
    <a href="suppressionrisque.php?id=<?php echo $data['id']; ?>"><img src="img/delete.png" alt="delete" class="delete"></a>
    <?php
}

$variable->closeCursor();
?>
<!--Ajout Solution-->
        <form action="recette.php?id=<?php echo $id ?>" method="post">
             <textarea name="solution" rows="10" cols="50" placeholder="Décrivez vos solutions ..."></textarea>
            <br>
            <input class="button-add" type="submit" value="Ajouter les solutions"/>
        </form>
    </div>
<?php
if (isset($_POST['solution']) && !empty($_POST['solution'])
) {
    /* stockage des données*/
    $request = $db->prepare('INSERT INTO solution(name, recette_id) VALUES(:name, :recette_id)');
    $request->execute(
        array(
            'name'=>$_POST['solution'],
            'recette_id'=>$id

        )

    );
};
?>
<?php
$variable= $db->query("SELECT id, name FROM solution" );
while($data =$variable->fetch()){
    ?>

    <p><?php echo $data['name'];?></p>
    <a href="suppressionsolution.php?id=<?php echo $data['id']; ?>"><img src="img/delete.png" alt="delete" class="delete"></a>
    <?php
}

$variable->closeCursor();
?>

<!--Ajout matrice-->
    <div class="section color"  id="page-8">
        <div class="titre">La Matrice :</div>
        <form action="recette.php?id=<?php echo $id ?>" method="post">
            <input style="width: 320px" class="border-input" type="text" name="matrice" placeholder="Indiquez votre matrice ..." />
            <br>
            <input class="button-add" type="submit" value="Ajouter"/>
        </form>
<?php
if (isset($_POST['matrice']) && !empty($_POST['matrice'])
) {
    /* stockage des données*/
    $request = $db->prepare('INSERT INTO matrice(titre, recette_id) VALUES(:titre, :recette_id)');
    $request->execute(
        array(
            'titre'=>$_POST['matrice'],
            'recette_id'=>$id

        )

    );
};
$variable= $db->query("SELECT id, titre, bool FROM matrice" );
while($data =$variable->fetch()){
    ?>
    <p><?php echo $data['titre'];echo ' '; echo $data['bool'];?></p>
    <a href="suppressionmatrice.php?id=<?php echo $data['id']; ?>"><img src="img/delete.png" alt="delete" class="delete"></a>
        <form action="recette.php?id=<?php echo $id ?>" method="post">
            <p>Validé<input type="radio" name="bool" value="Oui" >Non validé
            <input type="radio" name="bool" value="Non" checked>
            <br>
            <input class="button-add" type="submit" value="Ajouter"/>
        </form>

    <?php
}
if (isset($_POST['bool']) && !empty($_POST['bool'])
) {
    /* stockage des données*/
    $update = $db->prepare("UPDATE matrice SET bool=:bool");
    $update->execute(
        array(
            'bool'=>$_POST['bool']

        )
    );
};
$variable->closeCursor();
?></div>
    <!--Ajout recettage-->
    <div class="section"  id="page-9">
        <div class="titre">Votre feuille de Recettage :</div>
        <form action="recette.php?id=<?php echo $id ?>" method="post">
            <textarea name="recettage" rows="10" cols="50" placeholder="Décrivez votre recettage ..."></textarea>
            <br>
            <input class="button-add" type="submit" value="Ajouter"/>
        </form>
    </div>
<?php
if (isset($_POST['recettage']) && !empty($_POST['recettage'])
) {
    /* stockage des données*/
    $request = $db->prepare('INSERT INTO recettage (name, recette_id) VALUES(:name, :recette_id)');
    $request->execute(
        array(
            'name'=>$_POST['recettage'],
            'recette_id'=>$id

        )

    );
};
$variable= $db->query("SELECT id, name FROM recettage" );
while($data =$variable->fetch()){
    ?>

    <p><?php echo $data['name'];?></p>
    <a href="suppressionrecettage.php?id=<?php echo $data['id']; ?>"><img src="img/delete.png" alt="delete" class="delete"></a>
    <?php
}

$variable->closeCursor();


$idauthor = $_SESSION['id_user'];
$variable= $db->query("SELECT id, titre FROM recette" );
while($data =$variable->fetch()){
    ?>
    <br>
    <a href="pdftemplate/template.php?id=<?php echo $data['id']; ?>"><p> <?php echo $data['titre']; ?> </p></a>
    <?php
}
$variable->closeCursor();
?>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-scrollTo').on('click', function() { // Au clic sur un élément
            var page = $(this).attr('href'); // Page cible
            var speed = 750; // Durée de l'animation (en ms)
            $('html, body').animate( { scrollTop: $(page).offset().top }, speed ); // Go
            return false;
        });
    });
</script>
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>

