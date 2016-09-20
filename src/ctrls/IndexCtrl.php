<?php
 header('Content-Type: text/html; charset=UTF-8');
class IndexCtrl extends Pagina {
	const SIN_PRIVILEGIOS = "No tiene los permisos suficientes para crear usuarios.";
	const USUARIO_NO_AUTENTICADO = "Para esta operaci&oacute;n es obligatorio estar autenticado.";
	
	public function __construct(){
		
		//Singleton::_modelos();
		//die("");
		
		// Aquí se centralizan todas las operaciones de envío de datos: POST, GET ó REQUEST
		if ( isset( $_REQUEST ) ) {
			
			if( isset( $_REQUEST[ "cmd" ] ) ){				
				$url_baseCtrls = dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . "ctrls" . DIRECTORY_SEPARATOR;
				$this->renderCtrl($url_baseCtrls . "Servicios.php");
								
				if( $_REQUEST["cmd"] == "talleres" ){
					echo Servicios::ListaTaller();
					die("");
				}
				
				if( $_REQUEST["cmd"] == "mesas" ){
					echo Servicios::ListaMesas();
					die("");
				}
				
				if( $_REQUEST["cmd"] == "procesos" ){
					echo Servicios::ListaProcesos();
					die("");
				}
				
				if( $_REQUEST["cmd"] == "guardar" ){
					echo Servicios::Guardar();
					die("");
				}	

            	if( $_REQUEST["cmd"] == md5("exportarfull") ){
					Servicios::ExportarDatos();
					die("");
				}

                if( $_REQUEST["cmd"] == md5("exportarfullentrevista") ){
				Servicios::ExportarDatosEntrevista();
		        die("");
		        }

                if( $_REQUEST["cmd"] == md5("exportarfullindicadores") ){
				Servicios::ExportarDatosIndicadores();
		        die("");
		       }	
		   }
		}
		
		if( isset( $_POST ) ){
			
			// Agregar campos comunes
			if (isset( $_POST["ajax"] )) {
				session_start();
				
				if( Seguridad::isLogin() ){
					
					if( $_POST["ajax"] == "infoqr" ){
						//Infoqr
						$iqr = new Infoqr();
						$dat = Utiles::getBaseUrl() . "src/libs/infoqr/" . $iqr->Iniciar();
						$datos = "data:image/png;base64," . base64_encode($dat) . "<br />\n";
						$datos .= $dat;
						die( $datos );
					} else {
						$url_baseCtrls = dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . "ctrls" . DIRECTORY_SEPARATOR;
						$this->renderCtrl($url_baseCtrls . "OperacionesCtrl.php");
						
						$res[ "id" ] = OperacionesCtrl::SalvarDatosTbComunes();					
						die( json_encode( $res ) );
					}
					
				}
				else{
					die("error: Cuenta errada");
				}
			}
			
			if( isset( $_POST["cmd"] ) ){
				
				$autorizado = array( 
						"Guardar Usuarios" => array( "clase" => "Usuarios", "permisos" => 2 )
						,"Agregar Procesos" => array( "clase" => "Procesos", "permisos" => 2 )
						,"Guardar Mesas" => array( "clase" => "Mesas", "permisos" => 2 )
						,"Guardar Categorias" => array( "clase" => "Categorias", "permisos" => 2 )
				 );
				
				// Usuarios
				if( isset( $_POST["cmd"] ) ){
					if( !isset($_SESSION) ){
					    session_start();
					}
					
					$url_baseCtrls = dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . "ctrls" . DIRECTORY_SEPARATOR;
					$this->renderCtrl($url_baseCtrls . "OperacionesCtrl.php");
					
					// Adición común
					foreach ($autorizado as $k => $v) {
						if($_POST["cmd"] == $k){
							if( $this->commonSecurity( $v["permisos"] ) ){
								if( isset( $_FILES ) ){									
									$url_baseRepo = dirname(dirname( dirname( __FILE__ ) )) . DIRECTORY_SEPARATOR . Config::CARPETA_REPOSITORIOS . DIRECTORY_SEPARATOR;
									
									$tipos = array(	"image/jpeg" => "image/jpeg",
													"image/png" => "image/png");
									$sali = Utiles::SubirArchivos($url_baseRepo, $tipos,"imagen",true);
									if( $sali !== false ){
										foreach ($sali as $idImg => $vlImg) {
											$partFile = pathinfo($vlImg);
											$_POST["imagen"][$idImg] = $partFile["basename"];
										}
									}
								}
								
								$idResp = Pagina::mensajeComun( $v["clase"], $k, $this);
								
							}
						}
					}
					
					if($_POST["cmd"] == md5("estadoinactivo")){
						if( $this->commonSecurity(2) ){
							$ide = $_POST["ide"];
							$objU = $_POST["obj"];
							$u = new Usuarios();
							$u->setId( Seguridad::ElHash("Usuarios", $objU, "Id") );
							$ou = $u->readInfoById();
							$ou->setEstado_id( Seguridad::ElHash("Estado", $ide, "Id") );
							$ou->updateData();
						}
					}
					
					if( $_POST["cmd"] == md5("modificarfrm") ){
						if( $this->commonSecurity(2) ){														
							OperacionesCtrl::CargarDatosTbComunes();
						}
					}
					
				}
				
				// Carga Masiva Procesos
				if( $_POST["cmd"] == md5("cargaMasivaProcesos") ){
					if( $this->commonSecurity(2) ){
						$this->setMensaje( OperacionesCtrl::CargaMasivaProcesos() );
					}
				}
				
				// Eliminar campos comunes
				if( $_POST["cmd"] == md5("eliminarfrm") ){
					if( $this->commonSecurity(2) ){
						OperacionesCtrl::EliminarDatosTbComun();
					}
				}
				
				// Operaciones Backups
				if( $_POST["cmd"] == md5("crearbackup") ){
					$url_baseCtrls = dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . "ctrls" . DIRECTORY_SEPARATOR;
					$this->renderCtrl($url_baseCtrls . "BackupsCtrl.php");
				
					try{
						BackupsCtrl::MkBackUp();
					}
					catch (Exception $e)
					{
						self::setMensaje( $e->getMessage() );
					}
				}
				
				if( $_POST["cmd"] == md5("usarbackup") ){
					$url_baseCtrls = dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . "ctrls" . DIRECTORY_SEPARATOR;
					$this->renderCtrl($url_baseCtrls . "BackupsCtrl.php");
				
					try{
						self::setMensaje( "<pre>" . implode("\n", BackupsCtrl::UseBackUp() ) . "<pre>" );
					}
					catch (Exception $e)
					{
						self::setMensaje( $e->getMessage() );
					}
				}
				
				
				if( $_POST["cmd"] == md5("limpiarrespuestas") ){
					$url_baseCtrls = dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . "ctrls" . DIRECTORY_SEPARATOR;
					$this->renderCtrl($url_baseCtrls . "BackupsCtrl.php");
					BackupsCtrl::LimpiarMesas();
				}
				
				if( $_POST["cmd"] == md5("valoresfabrica") ){
					$url_baseCtrls = dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . "ctrls" . DIRECTORY_SEPARATOR;
					$this->renderCtrl($url_baseCtrls . "BackupsCtrl.php");
					self::setMensaje ( BackupsCtrl::restaurarDeFabrica() );
				}
				
				// Operaciones Crear Talleres
				if( $_POST["cmd"] == md5("mkTaller") ){
					$url_baseCtrls = dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . "ctrls" . DIRECTORY_SEPARATOR;
					$this->renderCtrl($url_baseCtrls . "AdminCtrl.php");
					$r = AdminCtrl::CrearTaller();
					
					if(sizeof($r) > 0){
						echo implode("\n", $r );
					}
					else{
						$txtTmp = "<span class=\"ui-icon ui-icon-circle-check\" style=\"float:left; margin:0 7px 50px 0;\"></span>";
						$txtTmp .= "Creaci\xF3n exitosa.";
						echo $txtTmp;
					}
					die("");
				}
				
			}
		}
		
	}
	
	private function commonSecurity( $perfil ){
		if ( Seguridad::isLogin() ) {
			if( isset( $_SESSION["usu"] ) ){
				$usu = $_SESSION["usu"];
				if( $usu->getPerfilusuarios_id() <= $perfil ){
					return true;
				}
				else{
					self::setMensaje(self::SIN_PRIVILEGIOS);
					return false;
				}
			}
			else{
				self::setMensaje(self::USUARIO_NO_AUTENTICADO);
				return false;
			}
		}
		else {
			self::setMensaje(self::USUARIO_NO_AUTENTICADO);
			return false;
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
		
		$url_base = dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . "tpls" . DIRECTORY_SEPARATOR;
		
		include_once $url_base . "Encabezado.phtml" ;
		
		if( Seguridad::isLogin() ){
			if( isset( $_REQUEST[ "logout" ] ) ){
				Seguridad::logout();
				@header( "location: ./index.php" );
				echo "<script type=\"text/javascript\">location.href='./index.php';</script>";
			}
			
			if( isset( $_REQUEST["pageid"] ) ){
				
				$rutaVista = $url_base . $_REQUEST["pageid"];
				if( $_REQUEST["pageid"] != Config::PAGINA_LOGIN ){
					
					if( file_exists($rutaVista) ){
						$this->renderCtrl( $rutaVista );
					}else{ 
						$this->setMensaje("P&aacute;gina no existente!");
						$this->renderCtrl( $url_base . Config::PAGINA_ERROR );
					}
					
				}else{
					$rutaVista = $url_base . Config::PAGINA_WORKSPACE;
					$this->renderCtrl( $rutaVista );	
				}
				
			}else{
				$rutaVista = $url_base . Config::PAGINA_WORKSPACE;
				$this->renderCtrl( $rutaVista );
			}
		}else{
			if( isset( $_POST["cmd"] ) ){
				if( isset( $_POST["usuario"] ) && isset( $_POST["clave"] ) ){
					if( strlen( trim( $_POST["usuario"] ) ) > 0 || strlen( trim( $_POST["clave"] ) ) > 0 ){
						if( Seguridad::loginAdmin($_POST["usuario"], $_POST["clave"]) ){
							@header( "location: ./index.php" );
							echo "<script type=\"text/javascript\">location.href='./index.php';</script>";
						}else{
							$this->setMensaje("Usuario o Clave inv&aacute;lida!");
						}
					}else{
						$this->setMensaje("Campos vac&iacute;os!");
					}
				}
			}
			
			$this->renderCtrl( $url_base . Config::PAGINA_LOGIN );
		}
		
		$this->renderCtrl( $url_base . Config::PAGINA_PIE );
		
		echo "	\n";
		echo "	</body>\n";
		echo "</html>";
	}
	
}
?>