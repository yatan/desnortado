<?php

include_once('./include/funciones.php');

$or = $_GET['or'];
$de = $_GET['dest'];
$inter = $_GET['inter'];

switch($inter)
{
	case 1://Coger
		$usuario = $_SESSION['obj_usuario'];
		sql("UPDATE ownership SET owner_id = ". $usuario->id_usuario .", X = ".$_SESSION['obj_usuario']->X().", Y = ".$_SESSION['obj_usuario']->Y()." WHERE item_id = ".$de,true);
	break;
	default:
	break;
}

?>