<link rel="stylesheet" href="css/style.css">
<div class="Table">
    <div class="Title">
        <p>Mapa</p>
    </div>
    <?php
	include ("./include/funciones.php");
	$x_centro = 0;
	$y_centro = 0;
	$x_rango = 2;
	$y_rango = 2;
	$items = ItemsInMap($x_centro,$y_centro,$x_rango,$y_rango);
    for ($y = $y_centro + $y_rango; $y >= $y_centro - $y_rango; $y--) {
       echo "<div class=\"Row\">";
       for ($x = $x_centro - $x_rango; $x <= $x_centro + $x_rango; $x++) { 
           echo "<div class=\"Cell\">";
           echo "<p>[$x] [$y]</p>";
		   foreach($items[$x][$y] as $item)
		   {
			   print"item";
		   }
           echo "</div>";
       }
       echo "</div>";
    }
    ?>
</div>