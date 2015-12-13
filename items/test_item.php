<?php
	require("objeto_item.php");
	$item = new item(1);
	
	echo $item->getNombre()."<br>";
	echo "<img src='". $item->getImg() ."'/><br>";
	echo $item->getDescripcion()."<br>";
	if($item->getAtaque() > 0)
		echo "Ataque: ". $item->getAtaque()."<br>";
?>