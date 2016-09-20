<?php 
/**
 *
 * @author yalfonso
 *
 */
  header('Content-Type: text/html; charset=UTF-8');
class Vwresultados extends Clsdatos { 

	private $id = 0; 
	private $valor = ""; 
	private $nombre = ""; 
	private $nombretaller = ""; 
	private $nombremesa = ""; 
	private $mesas_id = 0; 
	private $talleres_id = 0; 
	private $plann_temas_id = 0;

	public function getId (){ 
		return $this->id;
	} 
	public function setId ( $vl ){ 
		$this->id = $vl;
	} 
	public function getValor (){ 
		return $this->valor;
	} 
	public function setValor ( $vl ){ 
		$this->valor = $vl;
	} 
	public function getNombre (){ 
		return $this->nombre;
	} 
	public function setNombre ( $vl ){ 
		$this->nombre = $vl;
	} 
	public function getNombretaller (){ 
		return $this->nombretaller;
	} 
	public function setNombretaller ( $vl ){ 
		$this->nombretaller = $vl;
	} 
	public function getNombremesa (){ 
		return $this->nombremesa;
	} 
	public function setNombremesa ( $vl ){ 
		$this->nombremesa = $vl;
	} 
	public function getMesas_id (){ 
		return $this->mesas_id;
	} 
	public function setMesas_id ( $vl ){ 
		$this->mesas_id = $vl;
	} 
	public function getTalleres_id (){ 
		return $this->talleres_id;
	} 
	public function setTalleres_id ( $vl ){ 
		$this->talleres_id = $vl;
	} 
	public function getPlann_temas_id(){
		return $this->plann_temas_id;
	}
	public function setPlann_temas_id($vl){
		$this->plann_temas_id = $vl;
	}
} 
?>