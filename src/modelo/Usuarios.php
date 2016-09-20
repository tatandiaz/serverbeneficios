<?php
/**
 *
 * @author yalfonso
 *
 */
  header('Content-Type: text/html; charset=UTF-8');
class Usuarios extends Clsdatos {
	
	private $id = 0; 
	private $nombres = "";	
	private $apellidos = "";
	private $perfilusuarios_id = 0;
	private $estado_id = 0;
	private $mail = "";
	private $usuario = "";
	private $clave = "";
	private $creado = "";
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	public function getNombres() {
		return $this->nombres;
	}
	public function setNombres($nombres) {
		$this->nombres = $nombres;
	}
	public function getApellidos() {
		return $this->apellidos;
	}
	public function setApellidos($apellidos) {
		$this->apellidos = $apellidos;
	}
	public function getMail() {
		return $this->mail;
	}
	public function setMail($mail) {
		$this->mail = $mail;
	}
	public function getPerfilusuarios_id() {
		return $this->perfilusuarios_id;
	}
	public function setPerfilusuarios_id($idperfil) {
		$this->perfilusuarios_id = $idperfil;
	}
	public function getEstado_id() {
		return $this->estado_id;
	}
	public function setEstado_id($idestado) {
		$this->estado_id = $idestado;
	}
	public function getUsuario() {
		return $this-> usuario;
	}
	public function setUsuario($usuario) {
		$this->usuario = $usuario;
	}
	public function getClave() {
		return $this-> clave;
	}
	public function setClave($clave) {
		$this->clave = md5($clave);
	}
	public function getCreado() {
		return $this-> creado;
	}
	public function setCreado($creado) {
		$this->creado = $creado;
	}

}

?>