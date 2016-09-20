<?php
 header('Content-Type: text/html; charset=UTF-8');
class WorkspacehomeCtrl  extends Pagina {

	public function __construct(){
		$this->setSubfolders("home" . DIRECTORY_SEPARATOR);
	}
	
}
?>