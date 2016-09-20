<?php 
/**
 *
 * @author yalfonso
 *
 */
  header('Content-Type: text/html; charset=UTF-8');
class Mesas extends Clsdatos { 

	private $id = 0; 
	private $nombre = ""; 
	private $visiblesugerencias = "";
	private $talleres_id = 0;

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
	public function getVisiblesugerencias (){ 
		return $this->visiblesugerencias;
	} 
	public function setVisiblesugerencias ( $vl ){ 
		$this->visiblesugerencias = $vl;
	} 
	public function getTalleres_id (){
		return $this->talleres_id;
	}
	public function setTalleres_id ( $vl ){
		$this->talleres_id = $vl;
	}
} 
?>