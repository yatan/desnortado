<link rel="stylesheet" href="css/style.css">
<div class="Table">
    <div class="Title">
        <p>Mapa</p>
    </div>
    <?php
    for ($i=0; $i < 10; $i++) {
       echo "<div class=\"Row\">";
       for ($j=0; $j < 10; $j++) { 
           echo "<div class=\"Cell\">";
           echo "<p>[$i] [$j]</p>";
           echo "</div>";
       }
       echo "</div>";
    }
    ?>
</div>