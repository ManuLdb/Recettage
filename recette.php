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