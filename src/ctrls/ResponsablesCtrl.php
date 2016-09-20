<?php
 header('Content-Type: text/html; charset=UTF-8');
class ResponsablesCtrl extends Pagina { 
	
	private $dependencias = array();
	
	public function __construct(){
		$this->setSubfolders("modelos" . DIRECTORY_SEPARATOR);
	}
	
	public function obtenerTablaConLlaves(){
		$extra = "where id > 1";
		if (isset( $_SESSION["usu"] )) {
			$encab1 = array();
				
			$pagId = isset( $_POST["paginaV"] ) ? $_POST["paginaV"] : 0;
			
			return self::obtenerTablaHtml( 'Categorias', $encab1, $this->dependencias, '*', $extra, $pagId) ;
		}
	
		return "Sin permisos";
	}
	
}

?>