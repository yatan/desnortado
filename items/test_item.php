<link rel="stylesheet" href="../css/style.css">
<div id="borderimg1">
<?php
    require("../index_head.php");
	require("objeto_item.php");
    
    $id_item = $_GET['id'];
	
    $item = new item($id_item);
	
	echo "<h3>".$item->getNombre()."</h3><br>";
	echo "<img src='". $item->getImg() ."'/><br>";
	echo $item->getDescripcion()."<br>";
	if($item->getAtaque() > 0)
		echo "Ataque: ". $item->getAtaque()."<br>";
    if($item->getAcciones() != "")
        echo "Acciones disponibles: ". $item->getAcciones()."<br>";
    if($item->getRequiere() != "")
        echo "<p style='color:red;'\>Requiere: ". $item->getRequiere()."</p><br>";        
?>
</div>