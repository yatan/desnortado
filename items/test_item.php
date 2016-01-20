<link rel="stylesheet" href="../css/style.css">
<div id="borderimg1">
<?php
    require("../index_head.php");
	require("objeto_item.php");
    
    $id_item = $_GET['id'];
	
    $item = new item(0,$id_item);
	
	echo "<h3>".$item->getNombre()."</h3><br>";
	echo "<img src='". $item->getImg() ."'/><br>";
	echo $item->getDescripcion()."<br>";
	
    
?>
</div>