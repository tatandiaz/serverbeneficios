<?php 
 header('Content-Type: text/html; charset=UTF-8');
class Responsables extends Clsdatos { 

	private $id = 0; 
	private $nombre =""; 
	private $cargo ="";
	
   	public function getId (){ 
    	return $this->id;
	} 
	public function setId ( $vl ){ 
		$this->id = $vl;
	} 
	public function getNombre (){ 
		return $this->nombre;
	} 
	public function setNombre ( $vl ){ 
		$this->nombre = $vl;
	} 
	public function getCargo (){ 
		return $this->cargo;
	} 
	public function setCargo ( $vl ){ 
		$this->cargo= $vl;
	} 
} 
?>