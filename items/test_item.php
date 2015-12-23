<link rel="stylesheet" href="../css/style.css">
<div id="borderimg1">
<?php
	require("objeto_item.php");
	$item = new item(1);
	
	echo "<h3>".$item->getNombre()."</h3><br>";
	echo "<img src='". $item->getImg() ."'/><br>";
	echo $item->getDescripcion()."<br>";
	if($item->getAtaque() > 0)
		echo "Ataque: ". $item->getAtaque()."<br>";
?>
</div>