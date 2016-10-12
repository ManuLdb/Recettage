<?php
require("config/db.php");
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
<form action="recette.php?id=<?php echo $id ?>" method="post" enctype="multipart/form-data">
    <input type="name" name="name" placeholder="Titre" />
    <input type="file" name="image" placeholder="image" />
    <input type="submit" value="Ajouter"/>
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
    $error = "Extention incorrecte";
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
echo "Echec du transfert";
}
}
else{
echo $error;
}
$req = $db->prepare("SELECT path FROM image WHERE recette_id = '$id'");
$req->execute(array());
$donnees = $req->fetch();
// On affiche l'image
?>

<img src="<?php echo $donnees['path']; ?>">
<!--Ajout nom entreprise-->
<form action="recette.php?id=<?php echo $id ?>" method="post">
<input type="text" name="titre" placeholder="Nom de l'entreprise" />
<input type="submit" value="Ajouter"/>
</form>
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
?>
<?php
$variable= $db->query("SELECT id, titre FROM entreprise WHERE recette_id = '$id'" );
while($data =$variable->fetch()){
?>
<br>
<p><?php echo $data['titre'];?></p>
<?php
}

$variable->closeCursor();
?>



<!--Ajout Pitch-->
<form action="recette.php?id=<?php echo $id ?>" method="post">
     <textarea name="pitch" rows="10" cols="50">

    </textarea>
    <input type="submit" value="Ajouter"/>
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
?>
<?php
$variable= $db->query("SELECT id, titre FROM pitch WHERE recette_id = '$id'" );
while($data =$variable->fetch()){
    ?>
    <br>
    <p><?php echo $data['titre'];?></p>
    <?php
}

$variable->closeCursor();
?>
    <!--Ajout brief-->
    <form action="recette.php?id=<?php echo $id ?>" method="post">
         <textarea name="brief" rows="10" cols="50">

    </textarea>
        <input type="submit" value="Ajouter"/>
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
?>
<?php
$variable= $db->query("SELECT id, titre FROM brief WHERE recette_id = '$id'" );
while($data =$variable->fetch()){
    ?>
    <br>
    <p><?php echo $data['titre'];?></p>
    <?php
}

$variable->closeCursor();
?>
<!--Ajout Smart-->
<form action="recette.php?id=<?php echo $id ?>" method="post">
     <textarea name="smart" rows="10" cols="50">

    </textarea>
    <input type="submit" value="Ajouter"/>
</form>
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
?>
<?php
$variable= $db->query("SELECT id, titre FROM smart WHERE recette_id = '$id'" );
while($data =$variable->fetch()){
    ?>
    <br>
    <p><?php echo $data['titre'];?></p>
    <?php
}

$variable->closeCursor();
?>
<!--Ajout Equipe-->
<form action="recette.php?id=<?php echo $id ?>" method="post">
    <textarea name="equipe" rows="10" cols="50">

    </textarea>
    <input type="submit" value="Ajouter"/>
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
?>
<?php
$variable= $db->query("SELECT id, titre FROM equipe WHERE recette_id = '$id'" );
while($data =$variable->fetch()){
    ?>
    <br>
    <p><?php echo $data['titre'];?></p>
    <?php
}

$variable->closeCursor();
?>
    <!--Ajout process-->
    <form action="recette.php?id=<?php echo $id ?>" method="post">
        <input type="text" name="process" placeholder="process" />
        <input type="submit" value="Ajouter"/>
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
?>
<?php
$variable= $db->query("SELECT id, titre FROM process WHERE recette_id = '$id'" );
while($data =$variable->fetch()){
    ?>
    <p><?php echo $data['titre'];?></p>
    <form action="recette.php?id=<?php echo $id ?>" method="post">
        <p>On</p>
        <input type="radio" name="bool" value="2" >
        <p>Off</p>
        <input type="radio" name="bool" value="3" checked>
        <input type="submit" value="Ajouter"/>
    </form>
    <?php
}
if (isset($_POST['bool']) && !empty($_POST['bool'])
) {
    /* stockage des données*/
    $update = $db->prepare("UPDATE process SET bool=:bool WHERE recette_id = '$id'");
    $update->execute(
        array(
            'bool'=>$_POST['bool']

        )
    );
};
$variable->closeCursor();
?>