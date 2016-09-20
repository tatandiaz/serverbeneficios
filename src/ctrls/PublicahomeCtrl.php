<?php
 header('Content-Type: text/html; charset=UTF-8');
class PublicahomeCtrl extends Pagina {	
	private $pub = null;
	
	public function __construct(){
		$this->setSubfolders("home" . DIRECTORY_SEPARATOR);	
		
		$tmpEvento = new Publica();
		if ( isset( $_REQUEST["pub"] ) ){
			$tmpEvento->setId( $_REQUEST["pub"] );
			$this->pub = $tmpEvento->readInfoById();
		}
		
	}

	public function obtenerIdPubilca(){
		return $this->pub->getId();
	}
	
	public function obtenerTitulos(){
		return $this->pub->getTitulo();
	}
		
	public function obtenerImagenPublica(){
		return $this->pub->getImagen();
	}
	
	public function obtenerTexto(){
		return $this->pub->getTexto();
	}
	
}
?>