<?php
 header('Content-Type: text/html; charset=UTF-8');
class ProcesosCtrl extends Pagina { 
	
	private $dependencias = array();
	
	public function __construct(){
		$this->setSubfolders("modelos" . DIRECTORY_SEPARATOR);
		
		$mesas = new Mesas();
		$categ = new Categorias();
		$this->dependencias["mesas_id"] = Singleton::_arrayToTableReference( $mesas->readInfo() );
		$this->dependencias["categorias_id"] = Singleton::_arrayToTableReference( $categ->readInfo() );
	}
	
	public function obtenerMesas( $def = 1, $idm = "mesas_id" ){
		return self::obtenerListaHtml("Mesas", $idm . "[]", $idm . "_x", $def);
	}
	
	public function obtenerTablaConLlaves(){
		$extra = "";
		if (isset( $_SESSION["usu"] )) {
			$encab1["mesas_id"] = "Mesa";
				
			$pagId = isset( $_POST["paginaV"] ) ? $_POST["paginaV"] : 0;
			
			$defTb = (isset( $_POST["mesa_ftl"] ) ? $_POST["mesa_ftl"][0] : 0);
			if($defTb > 0){		// Datos por Mesa
				$extra = "where mesas_id = " . $defTb;
			}
			
			if( isset( $_POST["nofiltrar"] ) ) {
				$extra = "";
			}
			
			return self::obtenerTablaHtml( 'Procesos', $encab1, $this->dependencias, '*', $extra, $pagId, self::REGISTROS_PAGINA, "Procesos") ;
		}
	
		return "Sin permisos";
	}
	
}
?>