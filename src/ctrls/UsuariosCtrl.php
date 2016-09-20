<?php
 header('Content-Type: text/html; charset=UTF-8');
class UsuariosCtrl extends Pagina {
	private $dependencias = array();
		
	public function __construct(){
		$this->setSubfolders("modelos" . DIRECTORY_SEPARATOR);
		
		$perfilusr = new Perfilusuarios();
		$estadousr = new Estado();
		$this->dependencias["perfilusuarios_id"] = Singleton::_arrayToTableReference( $perfilusr->readInfo());
		$this->dependencias["estado_id"] = Singleton::_arrayToTableReference( $estadousr->readInfo());
	}
	
	public function obtenerPerfilesUsuarios(){
		return Pagina::obtenerListaHtml("Perfilusuarios", "perfilusuarios_id[]", "perfilusuarios_id_x", 3);
	} 
	
	public function obtenerEstados(){
		return Pagina::obtenerListaHtml("Estado", "estado_id[]", "estado_id_x", 1);
	} 

	public function obtenerTablaConLlaves(){
		$extra = "";
		if (isset( $_SESSION["usu"] )) {
			
			$usu = $_SESSION["usu"];			
			if ( $usu->getPerfilusuarios_id() == "2" ) {
				$extra = "where perfilusuarios_id >= 2 and estado_id = 1";
			}
			else if ( $usu->getPerfilusuarios_id() == "3" ) {
				$extra = "where id = " . $usu->getId() . " and estado_id = 1 ";
			}
			
			return self::obtenerTablaHtml( 'Usuarios', array('perfilusuarios_id' => 'perfil', 'estado_id' => 'estado'), $this->dependencias, 'id,nombres,apellidos,perfilusuarios_id,estado_id,mail,usuario,creado', $extra) ;
		}
		
		return "Sin permisos";
	}
	
}
?>