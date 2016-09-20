<?php 
/**
 *
 * @author yalfonso
 *
 */
  header('Content-Type: text/html; charset=UTF-8');
class Estado extends Clsdatos { 

	private $id = 0; 
	private $nombre = ""; 

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
} 
?>