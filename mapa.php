<link rel="stylesheet" href="css/style.css">
<div class="Table">
    <div class="Title">
        <p>Mapa</p>
    </div>
    <?php
	$x_centro = 0;
	$y_centro = 0;
	$x_rango = 2;
	$y_rango = 2;

    for ($y = $y_centro + $y_rango; $y >= $y_centro - $y_rango; $y--) {
       echo "<div class=\"Row\">";
       for ($x = $x_centro - $x_rango; $x <= $x_centro + $x_rango; $x++) { 
           echo "<div class=\"Cell\">";
           echo "<p>[$x] [$y]</p>";
           echo "</div>";
       }
       echo "</div>";
    }
    ?>
</div>