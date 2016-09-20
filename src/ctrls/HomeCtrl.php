<?php
 header('Content-Type: text/html; charset=UTF-8');
class HomeCtrl extends Pagina {
	const REPO_ARCHIVOS = "repo";
	
	public function __construct(){
		date_default_timezone_set('America/Bogota');
		// Aquí se centralizan todas las operaciones de envío de datos: POST, GET ó REQUEST		
		
		if(isset($_REQUEST)){
			//$url_baseCtrls = dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . "ctrls" . DIRECTORY_SEPARATOR;
			//$this->renderCtrl($url_baseCtrls . "OperacionesHomeCtrl.php");
		}
		
		if( isset( $_POST ) ){
			// Starts here
			
			if( isset( $_POST["cmd"] ) ){
				
				// here too
				
			}
		}
		
	}
	
	private function renderCtrl( $rutaVista ){
		$vista = pathinfo( $rutaVista );
		$url_baseCtrls = dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . "ctrls" . DIRECTORY_SEPARATOR;
		$rutaCtrl = $url_baseCtrls . $vista[ 'filename' ] . "Ctrl.php";
		if( file_exists( $rutaCtrl ) ){
			include_once $rutaCtrl;
			$tmpNombreClase = $vista[ 'filename' ] . "Ctrl";
			$rutaCtrl = new $tmpNombreClase();
			$rutaCtrl->render();
		}else{
			include_once $rutaVista;
		}
	}
	
	public function render(){
		if(!isset($_SESSION)){
	    	session_start();
		}
		
		$url_base = dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . "tpls" . DIRECTORY_SEPARATOR ;
		$url_home = $url_base . "home" . DIRECTORY_SEPARATOR;
		include_once $url_home . "Encabezadohome.phtml" ;
		
		if( isset( $_REQUEST["pageid"] ) ){
			
			$urlp = base64_decode($_REQUEST["pageid"]);
				
			$rutaVista = $url_base . $urlp;
			if( $_REQUEST["pageid"] != Config::PAGINA_WORKSPACE_HOME ){
				
				if( file_exists($url_base . "modelos/" . $urlp)){
					$this->setMensaje("P&aacute;gina no existente!");
					$this->renderCtrl( $url_home . Config::PAGINA_ERROR );
				}
				else{
					if( file_exists($rutaVista) ){
						$this->renderCtrl( $rutaVista );
					}else{ 
						$this->setMensaje("P&aacute;gina no existente!");
						$this->renderCtrl( $url_home . Config::PAGINA_ERROR );
					}
				}
					
			}else{
				$rutaVista = $url_home . Config::PAGINA_WORKSPACE_HOME;
				$this->renderCtrl( $rutaVista );	
			}
				
		}else{
			$rutaVista = $url_home . Config::PAGINA_WORKSPACE_HOME;
			$this->renderCtrl( $rutaVista );
		}
		
		$this->renderCtrl( $url_home . Config::PAGINA_PIE_HOME );
		
		echo "	\n";
		echo "	</body>\n";
		echo "</html>";
	}
	
}
?>