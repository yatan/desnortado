<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 check_stat($status): Funcion para comprobar un estado alterado al jugador. True si lo tiene, false en caso contrario.
 del_stat($status): Funcion para quitar un estado alterado al jugador. False si no borra. Array de estados en caso contrario.
 add_stat($status): Funcion para añadir al jugador un estado. True si la añade, false en contra.
 */
class usuario
{
    public $id_usuario;
	public $nick;
	public $X;
	public $X_rango;
	public $Y_rango;
	public $Y;
	public $HP;
	public $AP;

    
    function usuario($id){
		
        $usuario = sql("SELECT * FROM players_game WHERE id = ".$id);
        if ($usuario==false)
		{
            return false;
		}
        else{
		$this->id_usuario = $id;	
		$this->nick = $usuario['nick'];
		$this->X = $usuario['X'];
		$this->Y = $usuario['Y'];
		$this->X_rango = 2;
		$this->Y_rango = 2;
		$this->HP = $usuario['HP'];
		$this->AP = $usuario['AP'];
		}
    }
	
	function check_stat($stat) {
    $sql = sql("SELECT status FROM players_game WHERE id = " . $this->id_usuario);
    $sql = explode(',', $sql);
    $flag = false;
    foreach ($sql as $status) {
        if ($status == $stat) {
            $flag = true;
            break;
        }
    }
    return $flag;
}

function add_stat($stat) {
    if ($this->check_stat($stat, $this->id_usuario) == false) {
        $sql = sql("SELECT status FROM players_game WHERE id = " . $this->id_usuario);
        $sql .= $stat . ',';
        sql("UPDATE players_game SET status = '" . $sql . "' WHERE id = " . $this->id_usuario,true);
        $sql = true;
    } else {
        $sql = false;
    }
    return $sql;
}
function list_stat($id) {
    $sql = sql("SELECT status FROM players_game WHERE id = " . $this->id_usuario);
    $sql = explode(',', $sql);
    foreach ($sql as $status) {
        $list[] = $status;
    }
    unset($list[count($list) - 1]);
    return $list;
}
function del_stat($stat) {
    if ($this->check_stat($stat, $this->id_usuario) == true) {
        $list = $this->list_stat($this->id_usuario);
        $new_stat = "";
        foreach ($list as $status) {
            if ($status != $stat) {
                $new_stat .= $status . ",";
            }
        }
        sql("UPDATE players_game SET status = '" . $new_stat . "' WHERE id = " . $this->id_usuario,true);
		return $new_stat;
    }
    return false;
}
	
}
?>