<?php
 header('Content-Type: text/html; charset=UTF-8');
class MesasCtrl extends Pagina { 
	
	private $dependencias = array();
	
	public function __construct(){
		$this->setSubfolders("modelos" . DIRECTORY_SEPARATOR);
	}
	
	public function obtenerTablaConLlaves(){
		$extra = "";
		if (isset( $_SESSION["usu"] )) {
			$encab1 = array();
				
			$pagId = isset( $_POST["paginaV"] ) ? $_POST["paginaV"] : 0;
			
			return self::obtenerTablaHtml( 'Mesas', $encab1, $this->dependencias, '*', $extra, $pagId) ;
		}
	
		return "Sin permisos";
	}
	
}
?>