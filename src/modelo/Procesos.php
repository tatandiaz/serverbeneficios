<?php 
/**
 *
 * @author yalfonso
 *
 */
  header('Content-Type: text/html; charset=UTF-8');
class Procesos extends Clsdatos { 

	private $id = 0; 
	private $proceso = ""; 
	private $sugerencia = ""; 
	private $fecha = ""; 
	private $mesas_id = 0; 
	private $categori_id = 0; 
	private $talleres_id = 0; 
    private $responsables_id=0;
    private $categoriacliente_id=0;
    private $categoriaestrategia_id=0;

	public function getId (){ 
		return $this->id;
	} 
	public function setId ( $vl ){ 
		$this->id = $vl;
	} 
	public function getProceso (){ 
		return $this->proceso;
	} 
	public function setProceso ( $vl ){ 
		$this->proceso = $vl;
	} 
	public function getSugerencia (){ 
		return $this->sugerencia;
	} 
	public function setSugerencia ( $vl ){ 
		$this->sugerencia = $vl;
	} 
	public function getFecha (){ 
		return $this->fecha;
	} 
	public function setFecha ( $vl ){ 
		$this->fecha = $vl;
	} 
	public function getMesas_id (){ 
		return $this->mesas_id;
	} 
	public function setMesas_id ( $vl ){ 
		$this->mesas_id = $vl;
	} 
	public function getCategorias_id (){ 
		return $this->categorias_id;
	} 
	public function setCategorias_id ( $vl ){ 
		$this->categorias_id = $vl;
	} 
	public function getTalleres_id (){ 
		return $this->talleres_id;
	} 
	public function setTalleres_id ( $vl ){ 
		$this->talleres_id = $vl;
	}
    
    public function getResponsables_id (){ 
		return $this->responsables_id;
	} 
	public function setResponsables_id ( $vl ){ 
		$this->responsables_id = $vl;
	} 

       public function getCategoriacliente_id (){ 
		return $this->categoriacliente_id;
	} 
	public function setCategoriacliente_id ( $vl ){ 
		$this->categoriacliente_id = $vl;
	} 
      public function getCategoriaestrategia_id (){ 
		return $this->categoriaestrategia_id;
	} 
	public function setCategoriaestrategia_id ( $vl ){ 
		$this->categoriaestrategia_id = $vl;
	} 
 
} 
?>