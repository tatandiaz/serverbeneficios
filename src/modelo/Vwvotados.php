<?php 
/**
 *
 * @author yalfonso
 *
 */
  header('Content-Type: text/html; charset=UTF-8');
class Vwvotados extends Clsdatos { 

	private $categorias_id = 0; 
	private $votados = ""; 
	private $mesas_id = 0; 
	private $nombre = ""; 
	private $dependencia = ""; 
	private $color = ""; 

	public function getCategorias_id (){ 
		return $this->categorias_id;
	} 
	public function setCategorias_id ( $vl ){ 
		$this->categorias_id = $vl;
	} 
	public function getVotados (){ 
		return $this->votados;
	} 
	public function setVotados ( $vl ){ 
		$this->votados = $vl;
	} 
	public function getMesas_id (){ 
		return $this->mesas_id;
	} 
	public function setMesas_id ( $vl ){ 
		$this->mesas_id = $vl;
	} 
	public function getNombre (){ 
		return $this->nombre;
	} 
	public function setNombre ( $vl ){ 
		$this->nombre = $vl;
	} 
	public function getDependencia (){ 
		return $this->dependencia;
	} 
	public function setDependencia ( $vl ){ 
		$this->dependencia = $vl;
	} 
	public function getColor (){ 
		return $this->color;
	} 
	public function setColor ( $vl ){ 
		$this->color = $vl;
	} 
} 
?>