<?

session_start();
include_once("config.php");
include_once('config_variables.php');
select_lang();
/*

  Script con varias funciones:


  online(): Muestra si el servidor mysql esta disponible o no
  sql($sql): Ejecuta la sentencia sql, si da error muestra mensaje de error con die()
 *         devuelve un array con los valores obtenidos si hay mas de 1,
 * 			o el valor sin array si solo devuelve 1 valor
  enviar_mail($destino, $nick, $id)
 *        Envia un correo para activar la cuenta --EN DESARROLLO--
  anadir_foro($usuario, $password, $email)
 *         Añade un usuario al foro smf

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

    $result = mysql_query($sql);

    if ($result == false) {
        //error_log("SQL error: ".mysql_error()."\n\nOriginal query: $sql\n");
        // Remove following line from production servers 
        die("SQL error: " . mysql_error() . "\b<br>\n<br>Original query: $sql \n<br>\n<br>");
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

    //Si no devuelve nada sale de la funcion
    if ($result == 1)
        return true;

    if (mysqli_num_rows($result) == 1) {
        if (mysqli_num_fields($result) == 1) {
            $dato = array();
            $dato[0] = mysqli_fetch_row($result);
            return $dato;
        } else {
            $table = array();
            $table[0] = sql_data($result);
        }
    } else {

        $table = array();
        if (mysqli_num_rows($result) > 0) {
            $i = 0;
            while ($table[$i] = mysqli_fetch_assoc($result))
                $i++;
            unset($table[$i]);
        }
        mysql_free_result($result);
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

function check_lang($lengua) {

    $lengua_defecto = "es";

    $fichero = "./i18n/" . $lengua . ".php";

    if (!file_exists($fichero)) {
        $lengua = $lengua_defecto;
    }



    $_SESSION['i18n'] = $lengua;
    $_SESSION['i18n_default'] = $lengua_defecto;
}

function getString($text) {
    if (!isset($i18n_array)) {

        include $_SERVER['DOCUMENT_ROOT'] . '/i18n/' . $_SESSION['i18n_default'] . ".php";
        include $_SERVER['DOCUMENT_ROOT'] . '/i18n/' . $_SESSION['i18n'] . ".php";
    }

    return $i18n_array[$text];
}

?>