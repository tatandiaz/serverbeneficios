<?php 
/**
 *
 * @author yalfonso
 *
 */
  header('Content-Type: text/html; charset=UTF-8');
class Vwpregxmesa extends Clsdatos { 

	private $mesas_id = 0;
	private $nombre = ""; 
	private $total = ""; 
	
	public function getMesas_id(){
		return $this->mesas_id;
	}
	public function setMesas_id( $vl ){
		$this->mesas_id = $vl;
	}
	public function getNombre (){ 
		return $this->nombre;
	} 
	public function setNombre ( $vl ){ 
		$this->nombre = $vl;
	} 
	public function getTotal (){ 
		return $this->total;
	} 
	public function setTotal ( $vl ){ 
		$this->total = $vl;
	} 
} 
?>