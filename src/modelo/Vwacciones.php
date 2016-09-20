<?php 
/**
 *
 * @author yalfonso
 *
 */
  header('Content-Type: text/html; charset=UTF-8');
class Vwacciones extends Clsdatos { 

	private $id = 0; 
	private $plandeaccion = ""; 
	private $fecha = ""; 
	private $tema = ""; 
	private $categoria = ""; 
	private $perticipante = ""; 
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
	public function getPlandeaccion (){ 
		return $this->plandeaccion;
	} 
	public function setPlandeaccion ( $vl ){ 
		$this->plandeaccion = $vl;
	} 
	public function getFecha (){ 
		return $this->fecha;
	} 
	public function setFecha ( $vl ){ 
		$this->fecha = $vl;
	} 
	public function getTema (){ 
		return $this->tema;
	} 
	public function setTema ( $vl ){ 
		$this->tema = $vl;
	} 
	public function getCategoria (){ 
		return $this->categoria;
	} 
	public function setCategoria ( $vl ){ 
		$this->categoria = $vl;
	} 
	public function getPerticipante (){ 
		return $this->perticipante;
	} 
	public function setPerticipante ( $vl ){ 
		$this->perticipante = $vl;
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