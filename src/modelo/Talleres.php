<?php 
/**
 *
 * @author yalfonso
 *
 */
  header('Content-Type: text/html; charset=UTF-8'); 
class Talleres extends Clsdatos { 

	private $id = 0; 
	private $nombre = ""; 
	private $fecha = ""; 
	private $titulo = ""; 

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
	public function getFecha (){ 
		return $this->fecha;
	} 
	public function setFecha ( $vl ){ 
		$this->fecha = $vl;
	} 
	public function getTitulo (){ 
		return $this->titulo;
	} 
	public function setTitulo ( $vl ){ 
		$this->titulo = $vl;
	} 
} 
?>