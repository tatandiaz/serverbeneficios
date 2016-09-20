<?php 
/**
 *
 * @author johnn.diaz
 *
 */

 header('Content-Type: text/html; charset=UTF-8');
class Reto extends Clsdatos { 

	private $id = 0;
    private $id_mesa = 0;  
	private $reto = ""; 

	public function getId (){ 
		return $this->id;
	} 
	public function setId ( $vl ){ 
		$this->id = $vl;
	} 
	public function getId_mesa (){ 
		return $this->id_mesa;
	} 
	public function setId_mesa ( $vl ){ 
		$this->id_mesa = $vl;
	} 
	public function getReto (){ 
		return $this->reto;
	} 
	public function setReto ( $vl ){ 
		$this->reto  = $vl;
	}  
} 
?>