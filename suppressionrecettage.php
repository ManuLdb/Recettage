<?php
require("config/db.php");
session_start();

$idex=$_GET["id"];
if (isset($_GET['id'])) {
    $idex= htmlspecialchars($_GET['id']);



    $variable= $db->prepare("DELETE FROM recettage WHERE id=:id");
    $variable ->execute(
        array(
            'id'=>$idex
        )
    );
    header("Location: ".$_SERVER['HTTP_REFERER']."");


    $variable->closeCursor();
}

else{
    echo "erreur";
}

?>