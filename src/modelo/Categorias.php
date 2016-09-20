<?php 
/**
 *
 * @author yalfonso
 *
 */
  header('Content-Type: text/html; charset=UTF-8');
class Categorias extends Clsdatos { 

	private $id = 0; 
	private $talleres_id = 0; 
	private $nombre = ""; 
	private $color = ""; 
	private $dependencia = ""; 
	private $tiposcategoria_id = 0; 
	private $orden = 0;

	public function getId (){ 
		return $this->id;
	} 
	public function setId ( $vl ){ 
		$this->id = $vl;
	} 
	public function getTalleres_id (){ 
		return $this->talleres_id;
	} 
	public function setTalleres_id ( $vl ){ 
		$this->talleres_id = $vl;
	} 
	public function getNombre (){ 
		return $this->nombre;
	} 
	public function setNombre ( $vl ){ 
		$this->nombre = $vl;
	} 
	public function getColor (){ 
		return $this->color;
	} 
	public function setColor ( $vl ){ 
		$this->color = $vl;
	} 
	public function getDependencia (){ 
		return $this->dependencia;
	} 
	public function setDependencia ( $vl ){ 
		$this->dependencia = $vl;
	}

//OBTIENE LAS CATEGORIAS 
	public function getTiposcategoria_id (){ 
		return $this->tiposcategoria_id;
	} 
	public function setTiposcategoria_id ( $vl ){ 
		$this->tiposcategoria_id = $vl;
	}
	public function getOrden (){
		return $this->orden;
	}
	public function setOrden ( $vl ){
		$this->orden = $vl;
	}
} 
?>