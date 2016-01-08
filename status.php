<?php

$hp = $objeto_usuario->HP;
$ap = $objeto_usuario->AP;
$nick = $objeto_usuario->nick;
$estado = $objeto_usuario->status;

if($estado != null)
{
$a_estado = explode(",",$estado);
$i_estado="";
//Ir rellenando segun haga falta
/* foreach ($a_estado as $estado2) {
    switch($estado2)
    {
        case "a":
            $i_estado = $i_estado."<img title='".getString('stat_a')."' src='/images/status_bar/status/2.png'/> ";
            break;             
        default:
            $i_estado = $i_estado."";
    }
}*/ 
}
else
$i_estado = "<img src='./img/status_bar/status/1.png'/>";
echo "$i_estado -<b>$nick</b>"
." - "
."<img alt='hp'  src='./img/status_bar/life.gif'> $hp"
." - "
."<img alt='ap' src='./img/status_bar/gold.gif'> $ap"
." - ";
?> 