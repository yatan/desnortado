<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class usuario
{
    public $id_usuario;
	public $nick;
	public $X;
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
		$this->HP = $usuario['HP'];
		$this->AP = $usuario['AP'];
		}
    }
}
?>