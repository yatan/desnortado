<?php

include_once("./include/funciones.php");

$x = $_POST['X'];
$y = $_POST['Y'];
$id = $_POST['id'];

#Mover al jugador
sql("UPDATE players_game SET X = ".$x.", Y = ".$y." WHERE id = ".$id,1);
#Mover sus objetos.
sql("UPDATE ownership SET X = ".$x.", Y = ".$y." WHERE owner_id = ".$id,1);
?><script>window.location='/desnortado/';</script>