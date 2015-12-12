<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class usuario
{
    public $id_usuario;

    
    function usuario($id){
        $usuario = sql("SELECT * FROM players_game WHERE id = ".$id);
        if ($usuario==false)
            return false;
        else{
		$this->id_usuario = $id;	
		}
    }
}
?>