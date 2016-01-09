<link rel="stylesheet" href="css/style.css">

<div id="borderimg1">

<div class="Table">
    <div class="Title">
        <p>Mapa</p>
    </div>
    <?php
    include_once("index_head.php");
	include_once ("./include/funciones.php");
	$x_centro = $objeto_usuario->X();
	$y_centro = $objeto_usuario->Y();
	$x_rango = $objeto_usuario->X_rango;
	$y_rango = $objeto_usuario->Y_rango;
	$items = ItemsInMap($x_centro,$y_centro,$x_rango,$y_rango);
    for ($y = $y_centro + $y_rango; $y >= $y_centro - $y_rango; $y--) {
       echo "<div class=\"Row\">";
       for ($x = $x_centro - $x_rango; $x <= $x_centro + $x_rango; $x++) { 
           echo "<div class=\"Cell\">";
           echo "<p>[$x] [$y]</p>";
		   if(isset($items[$x][$y])){
			   foreach($items[$x][$y] as $item)
			   {
				   echo '<img src = "'.$item->getIcon().'" alt = "'.$item->id_item.'" >';
			   }
		   }
           echo "</div>";
       }
       echo "</div>";
    }
    ?>
</div>

<div class="Lateral_Derecho">
    <h2>Acciones</h2>
    <?php FrasesAccion(1);?>
</div>    

</div>  
</div>

<div id = "info_celda">
    
</div>    

<script>
$( "img" ).click(function() {
    $("#info_celda").load("items/test_item.php?id=" + $( this ).attr("alt"));
});
</script>