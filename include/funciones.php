<?php

include_once($_SERVER['DOCUMENT_ROOT']."/desnortado/usuarios/objeto_usuario.php");
session_start();
include_once("config.php");
include_once('config_variables.php');

select_lang();

/*
mysqli_online(): Devuelve un texto online si el server de sql esta disponible o rojo offline si no lo esta.
smtp_online(): Devuelve el estado del servidor smtp (mail)
mysqli_online2(): true si el server sql esta activo o false en caso contrario.
sql_error($sql): Manda una query y si da error suelta el mensaje de error con un die(). Si funciona devuelve el result normal.
sql_data($result): Devuelve los resultados en asociativo y los libera o false si no habia datos
sql($sql): Devuelve una unica cosa si en el resultado solo habia una fila y una columna. Si habia varias columnas, devuelve un array del tipo $resultado[idfila]['columna']
*Esto ha sido renombrado, si enceuntras alguna funcion sql2 renombrala como sql
enviar_mail($destino, $nick): Pues eso
check_lang($lengua): Carga en la variable de session $_SESSION["lang"] el idioma del usuario. Compruebo que el archivo esxiste en ./i18n/lang.php
getString($text): Coge el texto de id $text del diccionario del user
ItemsInMap($x_centro,$y_centro,$x_rango = 0,$y_rango = 0): Devuelve un array[x][y] con un array de los objetos_item de los item que hay en cada casilla[x][y] en el centro y rango indicados.
InteraccionesActivas($id_player): Devuelve un array de arrays con el id del item origen, stu tipoo y el tipo de interaccion [origen,oringe_tipo,inter_id] sin filtrar condiciones
InteraccionesPasivas($x_centro,$y_centro,$x_rango,$y_rango): Devuelve un array de arrays [destino,destino_tipo,inter_id] El ID DEL ITEM del objeto destino de la interaccion el TIPO DE ITEM y el TIPO de interaccion. Sin filtrar condiciones.
ListarInteracciones($id_usuario): Usa las dos funciones anteriores y muestra los objetos que pueden generar una interaccion con otros objetos en el rango de accion del jugador PERO sin filtrar parametros ni nada.
function FiltroInteracciones($posibles): Coge una array de interacciones y deja solo los posibles.
function CondicionesInteracciones($inter): Dada una interaccion, comprueba si es posible.
function Norma1($x1,$y1,$x2,$y2): Calcula distancia en norma 1 
function FrasesAccion($id): Imprime los links para realizar las acciones disponibles del jugador id
*/

function mysqli_online() {
    $ip = "localhost";
    $puerto = 3306;

    if ($fp = @fsockopen($ip, $puerto, $ERROR_NO, $ERROR_STR, (float) 0.5)) {
        fclose($fp);
        echo "<font color='Green'>Online</font>";
    } else {
        echo "<font color='Red'>OFFLINE</font>";
    }
}

function smtp_online() {
    $ip = "localhost";
    $puerto = 26;

    if ($fp = @fsockopen($ip, $puerto, $ERROR_NO, $ERROR_STR, (float) 0.5)) {
        fclose($fp);
        return true;
    } else {
        return false;
    }
}

//Funcion que devuelve true o false segun estado mysql
function mysqli_online2() {
    $ip = "localhost";
    $puerto = 3306;

    if ($fp = @fsockopen($ip, $puerto, $ERROR_NO, $ERROR_STR, (float) 0.5)) {
        fclose($fp);
        return true;
    } else {
        return false;
    }
}

function sql_error($sql) {
	/*global $server;
	global $dbuser;
	global $dbpass;
	global $database;
	$link = mysql_connect($server,$dbuser,$dbpass,$database);*/
	global $link;
    $result = mysqli_query($link,$sql);

    if ($result == false) {
        //error_log("SQL error: ".mysql_error()."\n\nOriginal query: $sql\n");
        // Remove following line from production servers 
        die("SQL error: " . mysqli_error($link) . "<br>\n<br>Original query: $sql \n<br>\n<br>");
    }
    return $result;
}

function sql_data($result) {

    if ($lst = mysqli_fetch_assoc($result)) {
        mysqli_free_result($result);
        return $lst;
    }
    return false;
}

function sql($sql,$override = false) {

    $result = sql_error($sql);
	
	if($override) return true;
	
    if (mysqli_num_rows($result) == 1) 
    {
        if (mysqli_num_fields($result) == 1) 
        {
            $dato = mysqli_fetch_row($result);
            return $dato[0];
        }
        else
            $table = sql_data($result);
    } 
    else 
    {
        $table = array();
        if (mysqli_num_rows($result) > 0) {
            $i = 0;
            while ($table[$i] = mysqli_fetch_assoc($result))
                $i++;
            unset($table[$i]);
        }
        mysqli_free_result($result);
    }
    return $table;
}

function enviar_mail($destino, $nick) {

    global $mail_activation;
//var_dump($mail_activation);
// subject
    $titulo = $mail_activation['activacion_titulo'];

// message
    $mensaje = $mail_activation['activacion_mensaje_titulo'] . $mail_activation['activacion_mensaje_cuerpo'];

// Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
    $cabeceras = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Cabeceras adicionales
    $cabeceras .= 'From: BirthofNations <admin@birthofnations.com>' . "\r\n";

// Mail it
    mail($destino, $titulo, $mensaje, $cabeceras);
}

function select_lang()
{//TBD: Elige la lengua del usuario, de momento se fuerza el es que es la unica
	check_lang('es');
}

function check_lang($lengua) {

    $lengua_defecto = "es";
    $fichero = "/i18n/" . $lengua . ".php";

    if (!file_exists($fichero)) {
        $lengua = $lengua_defecto;
    }

    $_SESSION['i18n'] = $lengua;
    $_SESSION['i18n_default'] = $lengua_defecto;
}

function getString($text) {
    if (!isset($i18n_array)) {

        include $_SERVER['DOCUMENT_ROOT'] . '/desnortado/i18n/' . $_SESSION['i18n_default'] . ".php";
        include $_SERVER['DOCUMENT_ROOT'] . '/desnortado/i18n/' . $_SESSION['i18n'] . ".php";
    }
	if(isset($i18n_array[$text]))
	{
		return $i18n_array[$text];
	}else{
		return "[[string ".$text." not found]]";
	}
}  

function ItemsInMap($x_centro,$y_centro,$x_rango = 0,$y_rango = 0){
	//Coge la "lista" de casillas 
	//Output del tipo $items[x][y][i] con i de 0 a los items que haya
	
	include_once($_SERVER['DOCUMENT_ROOT'] . "/desnortado/items/objeto_item.php");
	$items = array();
	
	$items_prov = sql("SELECT * FROM ownership WHERE owner_id = 0");//Items del suelo solo
    
    foreach($items_prov as $it)
    {//Por cada item en la casilla hacer el objeto y meterlo en el array de vuelta
        $items[$it['X']][$it['Y']][] = new item($it["item_id"]);
        //var_dump($it['item_id']);
    }
       
   
	return $items;
}

function InterPosible($id_inter,$id_item_activo,$id_item_pasivo)
{
	if($id_item_activo == 0){
		return true; #Comodin para cosas que hace el jugador.
	}
	return false;
}

function InteraccionesActivas($id_player)
{
	//ids y tipos de objetos del usuario
	$invent = sql_error("SELECT items.id_item, items.type FROM items INNER JOIN ownership ON ( items.id_item = ownership.item_id AND ownership.owner_id = ".$id_player.")");
	#Usamos error pq no queremos el formateo de sql cuando hay solo un item
	//Para cada objeto sacamos las acciones ACTIVAS
	$activos = array();
	foreach($invent as $item)
	{
		$obj_item = new item($item['id_item'],$item['type']);
		$inters = $obj_item->getActive();
		#Montar en el array
		if(!is_null($inters)){
			foreach($inters as $inter)
			{	//Item activo: su id y tipo. Id del tipo al que haria un interaccion (nulo pq aun no se sabe), el tipo y el id de interaccion. Como cicla salen todos los destinos posibles.
				$activos[] = array("origen" => $item['id_item'], "origen_tipo" => $item["type"],"destino" => "", "destino_tipo" => (string) "","inter_id" => (string) $inter->id);
			}
		}
	}

return $activos;
}

function InteraccionesPasivas($x_centro,$y_centro,$x_rango,$y_rango)
{
		$xmin = $x_centro - $x_rango;
	$xmax = $x_centro + $x_rango;
	$ymin = $y_centro - $y_rango;
	$ymax = $y_centro + $y_rango;
		$sql = "SELECT items.id_item, items.type FROM items INNER JOIN ownership ON ( items.id_item = ownership.item_id AND ownership.owner_id = 0 ) WHERE (ownership.X BETWEEN ".$xmin." AND ".$xmax.") AND (ownership.Y BETWEEN ".$ymin." AND ".$ymax.")";
	$invent = sql_error($sql);#Usamos error pq no queremos el formateo de sql cuando hay solo un item
	//Para cada objeto sacamos las acciones PASIVAS
	$pasivos = array();
	foreach($invent as $item)
	{
		$obj_item = new item($item['id_item'],$item['type']);
		$inters = $obj_item->getPassive();
		#Montar en el array
		if(!is_null($inters))
		{
			foreach($inters as $inter)
			{	//Item pasivo. Id (nulo pq no se conoce aun) del item que le realiza la accion. El tipo que deberia tener. Somos el destino, id y tipo de este item. Tipo de interaccion.
				$pasivos[] = array("origen" => "", "origen_tipo" => "", "destino" => $item['id_item'] , "destino_tipo" => $item['type'],  "inter_id" => (string) $inter->id);
			}
		}
	}

	return $pasivos;
}

function ListarInteracciones($id_usuario)
{//Dada la posicion e inventario de un jugador listar las interacciones posibles

	$jugador = $_SESSION['obj_usuario'];

	$activos = InteraccionesActivas(1);
	$pasivos = InteraccionesPasivas($jugador->X(),$jugador->Y(),$jugador->X_rango,$jugador->Y_rango); 

	$posible = array();

	foreach($activos as $activo)
	{
		foreach($pasivos as $pasivo)
		{
			if($activo['inter_id'] == $pasivo['inter_id'])
			{
				$posible[] = array("origen" => $activo['origen'], "origen_tipo" => $activo['origen_tipo'], "destino" => $pasivo['destino'] , "destino_tipo" => $pasivo['destino_tipo'],  "inter_id" => $pasivo['inter_id']);
			}
		}
	}
return $posible;
}
function FiltroInteracciones($posibles)
{//Coge una array de interacciones y deja solo los posibles.
	$reales = array();
	foreach($posibles as $inter)
	{
		if(CondicionesInteracciones($inter))
		{
			$reales[] = $inter;
		}
	}
	return $reales;
}
function CondicionesInteracciones($inter)
{//Dada una interaccion, comprueba si es posible.
//Debe devolver SIEMPRE true o false.
	switch($inter['inter_id'])
	{
	case 1: //Coger
		return true;
		break;
	case 2: //Cortar
		$activo = new item($inter['origen'],$inter['origen_tipo']);
		$pasivo = new item($inter['destino'],$inter['destino_tipo']);
		if(Norma1($activo->getX(),$activo->getY(),$pasivo->getX(),$pasivo->getY()) <= 1) //Si esta en casilla colindantes o en la misma
		{
			return true;
		}else{
			return false;
		}
		break;
	}
}

function Norma1($x1,$y1,$x2,$y2)
{//Calcula distancia en norma 1 
	return abs($x1-$x2) + abs($y1-$y2);
}

function FrasesAccion($id){
	$reales = FiltroInteracciones(ListarInteracciones($id));
	
	foreach($reales as $inter)
	{
		$item_or = new item($inter['origen']);
		$item_de = new item($inter['destino']);
		echo "<a href='accion.php?or=".$inter['origen']."&or_ty=".$inter['origen_tipo']."&dest=".$inter['destino']."&de_ty=".$inter['destino_tipo']."&inter=".$inter['inter_id']."'>".getString('inter_'.$inter['inter_id']."_or")." <img src='".$item_de->getIcon()."'> usando <img src='".$item_or->getIcon()."'></a><br>";
	}
}

function GetXML($id)
{
	$xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . "/desnortado/items/". $id.'.xml');
	return $xml;
}

function DeleteItem($id)
{
	sql("DELETE FROM items WHERE id_item = ".$id,1);
	sql("DELETE FROM ownership WHERE item_id = ".$id,1);
}

function FrasesMover($id,$x,$y)
{
	//Miramos si tiene piernas
	$ret = sql("SELECT items.id_item FROM items INNER JOIN ownership ON items.id_item = ownership.item_id WHERE ( items.type = 5 ) AND ownership.owner_id = ".$id);
	if($ret != NULL)
	{//Tiene piernas -> Anda
	echo <<<EOT
	<form action="mover.php" method="post">
	<input type="hidden" name="id" value=$id>		
	<input type="hidden" name="X" value=$x>
	<input type="hidden" name="Y" value=$y>
	<input type="submit" value="$x.$y">
	</form>
EOT;
	}else{//Sin piernas -> No anda
	echo <<<EOT
	<form action="mover.php" method="post">
	<input type="hidden" name="id" value=$id>		
	<input type="hidden" name="X" value=$x>
	<input type="hidden" name="Y" value=$y>
	<input type="submit" value="$x.$y" disabled>
	</form>
EOT;
	}
	
}
?>