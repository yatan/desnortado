<style type="text/css">
    .Table
    {
        display: table;
    }
    .Title
    {
        display: table-caption;
        text-align: center;
        font-weight: bold;
        font-size: larger;
    }
    .Heading
    {
        display: table-row;
        font-weight: bold;
        text-align: center;
    }
    .Row
    {
        display: table-row;
    }
    .Cell
    {
        display: table-cell;
        border: solid;
        border-width: thin;
        padding-left: 5px;
        padding-right: 5px;
    }
</style>

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