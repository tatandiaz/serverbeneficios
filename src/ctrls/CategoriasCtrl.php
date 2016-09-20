<?php

 header('Content-Type: text/html; charset=UTF-8');
class CategoriasCtrl extends Pagina { 
	
	private $dependencias = array();
	
	public function __construct(){
		$this->setSubfolders("modelos" . DIRECTORY_SEPARATOR);
	}
	
	public function obtenerDependencias( ){
		$def = 0;
		if( isset( $_POST["dependencia"] ) ){
			$def = $_POST["dependencia"];
		}
		return self::obtenerListaHtml("Categorias", "dependencia[]", "dependencia_x", $def);
	}
	
	public function obtenerTiposCategorias( $def = 1 ){
		$def = 1;
		$extra = "where id < 3";
		if( isset( $_POST["tiposcategoria_id"] ) ){
			$def = $_POST["tiposcategoria_id"];
		}
		return self::obtenerListaHtml("Tiposcategoria", "tiposcategoria_id[]", "tiposcategoria_id_x", $def,$extra);
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