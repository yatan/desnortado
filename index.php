<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<?php
include_once("index_head.php"); 
include_once("./include/funciones.php");
//Comprobacion del servidor mysql
if(mysqli_online2()==false)
    die("Hay un fallo en los servidores. Intentalo mas tarde");
//Comprobacion si el juego esta en mantenimiento
/*
if(sql("SELECT mantenimiento FROM settings")=="1" && !isset($_SESSION['is_admin']))
{
    include($_SERVER['DOCUMENT_ROOT']."/login/mantenimiento.php");
    die();    
}
*/
elseif(isset($_SESSION['is_admin']) && $_SESSION['is_admin']!="1")
{
    include($_SERVER['DOCUMENT_ROOT']."/login/mantenimiento.php");
    die();    
}
if(!isset($_SESSION['id_usuario']))
{
    include("login/login.php");
    exit;
}
else
{
    
require_once("usuarios/objeto_usuario.php");
$objeto_usuario = new usuario($_SESSION['id_usuario']);

//Si existe el idioma normalmente en la url del tipo /es/ lo establece como
//variable que se carga al principio '''$idioma'''
if(isset($_GET['lang']))
    $idioma = $_GET['lang'];

?>   
    <body> 
        <div class="blur">
            <div class="shadow">
                <div id="contenido">
                    <?php include("cabecera.php"); ?><br>
                    <div id="status">
                        <center>
                            <?php include("status.php"); ?>
                        </center>
                    </div>
                    <div id="menu">
                        <?php include("menu.php"); ?>  
                    </div><!--menu-->
                    <div id="cuerpo">
                        <center>
                        <?php
                        $to_load = "mapa"; #TBD: Qué debemos cargar en el mapa principal
                        if(isset($to_load))
                        {    
                            switch($to_load)
							{ // Este es el switch que carga el cuerpo principal
                            case "mapa":
                                include("mapa.php");
                                break;                             
                            default :
                                die(); //Default por si se pone algo incorrecto. Al futuro hay que cambiarlo
                            }
                        }
						//Aqui va lo de abajo
						?>
						<div id="columnas" style="padding: 10px; width: 58.4em; height: 25em;">
							<div id="columna1" style="float: right; width: 41em; height: 25em;">
							   <?php include("columna1.php"); ?>
							</div>

							<div id="columna2" style="float: left; height: 25em; width: 17em;">
							   <?php include("columna2.php"); ?>
							</div>
						</div><!-- columnas -->
                                

<?php 
}
?>

</body>
</html>