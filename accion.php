<?php

include_once('./include/funciones.php');

$or = $_GET['or'];
$or_tipo = $_GET['or_ty'];
$de = $_GET['dest'];
$de_tipo = $_GET['de_ty'];
$inter = $_GET['inter'];
$usuario = $_SESSION['obj_usuario'];
switch($inter)
{
	case 1://Coger
		sql("UPDATE ownership SET owner_id = ". $usuario->id_usuario .", X = ".$_SESSION['obj_usuario']->X().", Y = ".$_SESSION['obj_usuario']->Y()." WHERE item_id = ".$de,true);
		break;
	case 2://Cortar (Aunque se puede utilizar para transformaciones genericas)
		$xml = GetXML($de_tipo);
		$outputs = $xml->xpath('//item/pasivo/inter[id = "2"]/output');
		foreach($outputs as $out)
		{	//Recorremos los outputs 
			for($i = 0; $i < $out->cantidad; $i++)
			{
				sql("INSERT INTO items(type) VALUES ('".$out->item_id."')",true); #Añadir a bbdd items
				$last_id = $link->insert_id; #Pillar la id añadida
				if($out->donde == "inv")
				{#Meter en el inventario del jugador
					sql("INSERT INTO ownership(item_id,owner_id,X,Y) VALUES (".$last_id.",".$usuario->id_usuario.",".$usuario->X().",".$usuario->Y().")",1);
				}elseif($out['donde'] == "suelo"){#O dejar en el suelo
					sql("INSERT INTO ownership(item_id,owner_id,X,Y) VALUES (".$last_id.",0,".$usuario->X().",".$usuario->Y().")",1);
				}else{//Por si acaso, en el suelo
					sql("INSERT INTO ownership(item_id,owner_id,X,Y) VALUES (".$last_id.",0,".$usuario->X().",".$usuario->Y().")",1);
				}
			}
		}
		
		if((int)$xml->xpath('//item/pasivo/inter[id = "2"]/destruir')[0] == 1)
		{
			DeleteItem($de);
		}
		break;
	case 3:
		sql("UPDATE players_game SET HP = HP + 5 WHERE id = ".$usuario->id_usuario,true);
		break;
	default:
		break;
}

?><script>window.location='/desnortado/';</script>