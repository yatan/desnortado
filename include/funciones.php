<?php

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
var_dump($result);
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

function sql($sql) {

    $result = sql_error($sql);

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

    return $i18n_array[$text];
}

?>