<?php

//include("../include/funciones.php");
select_lang();

class item
{
	public $id_item;
	public $nombre_item;
	public $descripcion;
	public $ataque;
	public $peso;
	public $valor;
	public $img;	
	
	function item($id_item,$id_tipo = 0)
	{	
		if($id_tipo == 0)
		{
			$id_tipo = sql ("SELECT type FROM items WHERE id_item = " . $id_item);
		}
		if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/desnortado/items/". $id_tipo.'.xml'))
		{
		$xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . "/desnortado/items/". $id_tipo.'.xml');
		//print_r($xml);
		} 
		else
		{
			exit('Error abriendo '.$id_tipo.'.xml.');
		}
		
		$this->id_item = $xml->id[0];
		$this->nombre_item = $this->getNombrei18n((string) $xml->nombre_clave);
		$this->peso = $xml->peso[0];
		//Valor de venta es valor/2 al precio de compra (Ah si?)
		$this->valor = $xml->valor[0]/2;
		$this->img = $xml->img[0];
		//Si el item dispone de ataque, se le añade
		if(isset($xml->ataque[0]))
			$this->ataque = $xml->ataque[0];
		$this->descripcion = $this->getDescri18n((string) $xml->descripcion);
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
		return (string) './img/'.$this->img;
	}

}

?>