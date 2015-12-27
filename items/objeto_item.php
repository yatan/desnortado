<?php
/*
    Acciones:
                1 - Cortar
 
*/
include_once($_SERVER['DOCUMENT_ROOT'] . "/desnortado/include/funciones.php");
select_lang();

class item
{
	public $id_item;
	public $tipo;
	public $nombre_item;
	public $descripcion;
	public $ataque;
	public $peso;
	public $valor;
	public $img;	
	public $icon;
    public $acciones;
    public $requiere;
	
	function item($id_item)
	{	
		if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/desnortado/items/". $id_item.'.xml'))
		{
		$xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . "/desnortado/items/". $id_item.'.xml');
		} 
		else
		{
			exit('Error abriendo '.$id_item.'.xml.');
		}
		
		$this->id_item = $xml->id[0];
		$this->tipo = $id_item;
		$this->nombre_item = $this->getNombrei18n((string) $xml->nombre_clave);
        $this->descripcion = $this->getDescri18n((string) $xml->descripcion);
		$this->peso = $xml->peso[0];
		//Valor de venta es valor/2 al precio de compra (Ah si?)
		$this->valor = $xml->valor[0]/2;
		$this->img = $xml->img[0];
		$this->icon = $xml->icon[0];
		//Si el item dispone de ataque, se le añade
		if(isset($xml->ataque[0]))
			$this->ataque = $xml->ataque[0];
 		//Si tiene acciones el item
        if(isset($xml->acciones[0]))
			$this->acciones = $xml->acciones[0];    
        //Si el item requiere de alguna accion
        if(isset($xml->requiere[0]))
			$this->requiere = $xml->requiere[0];
            
	}
	
	function getNombrei18n($nombre)
	{
		return getString($nombre);
	}	
	
	function getDescri18n($descripcion)
	{
		return getString($descripcion);
	}
		
	//Acceso publico
	public function getNombre()
	{
		return (string) $this->nombre_item;
	}
	public function getDescripcion()
	{
		return (string) $this->descripcion;
	}
	public function getAtaque()
	{
		return (int) $this->ataque;
	}
	public function getPeso()
	{
		return (int) $this->peso;
	}
	public function getValor()
	{
		return (int) $this->valor;
	}
	public function getImg()
	{
		return (string) '/desnortado/img/'.$this->img;
	}
	public function getIcon()
	{
		return (string) '/desnortado/img/'.$this->icon;
	}
    public function getAcciones()
    {
        return (string) $this->acciones;
    }
    
    public function getRequiere()
    {
        return (string) $this->requiere;
    }

}

?>