<?php
 header('Content-Type: text/html; charset=UTF-8');
class PiehomeCtrl extends Pagina {
	
	public $estilos = array("one","two","three");
	
	public function __construct(){
		$this->setSubfolders("home" . DIRECTORY_SEPARATOR);
	}
	
	public function obtenerSlides(){
		$extra = "where estado_principal_id = 1 order by orden";
		$prin = new Principal();
		$aData = $prin->readInfo("*", $extra);
		
		return $aData;
	}
	
}
?>
