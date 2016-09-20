<?php
 header('Content-Type: text/html; charset=UTF-8');
class BackupsCtrl extends Pagina {
	const CARPETA_BK = "bk";
	private $base = "";
	private $fldbk = ""; 
	public static $arrEstadoUp = array();
	
	public function __construct(){
		$this->base = dirname(dirname(dirname(__FILE__)));
		$this->fldbk = $this->base . DIRECTORY_SEPARATOR . Config::CARPETA_REPOSITORIOS . DIRECTORY_SEPARATOR . self::CARPETA_BK;
	}
	
	public function getFldbk(){
		return $this->fldbk;
	}
	
	public function listarBackUps(){
		$lsFlBacks = array();
		$dir = $this->fldbk;
		if ($handle = opendir($dir)) {
		    while (false !== ($entry = readdir($handle))) {
		        if ($entry != "." && $entry != "..") {
		        	$fullPath = $dir . DIRECTORY_SEPARATOR . $entry;
		        	if( filetype($fullPath) == "file" ){
		        		$objFile = pathinfo($fullPath);
		        		if( $objFile['extension'] == "mem" ){
		            		$lsFlBacks[] = $entry;
		        		}
		        	}
		        }
		    }
		    closedir($handle);
		}
		
		return $lsFlBacks;
	}
	
	public function obtenerMesas($def = 1){
		$nombreLs = "mesas";
		$idLs = $nombreLs;
		$estilo = "";
		$mesas = Pagina::obtenerListado("Mesas", "*", "mesas");
		$txt = '<select name="' . $nombreLs . '" id="' . $idLs . '" class="' . $estilo . '" >';
		foreach ($mesas as $key => $value) {
			$sopti = "";
			if ($def == $value["id"]) {
				$sopti = ' selected="selected" ';
			}
			$txt .= '<option value="' . $value["id"] . '"' . $sopti . '>' . $value["nombre"] . '</option>';
		}
	
		$txt .= '<option value="0"' . ($def == 0 ? ' selected="selected" ' : '') . '>TODAS LAS MESAS</option>';
		$txt .= "</select>";
	
		return $txt;
	}
	
	public function usarBackup(){
		$matrizErr = array();
		if( isset( $_POST["cmb_lista_bkps"] ) ){
			if( strlen( trim( $_POST["cmb_lista_bkps"] ) ) > 0 ){
				$idTaller = 1;
				
				include_once $this->base . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "libs" . DIRECTORY_SEPARATOR . "mysql-tools" . DIRECTORY_SEPARATOR . "Mysql_backup_import.php";
				$dirnm = $this->fldbk;
				$flnm = $_POST["cmb_lista_bkps"];
				$chkfl = $dirnm . DIRECTORY_SEPARATOR . $flnm;
				
				$file_name = $chkfl;
				
				$string_data = file_get_contents($file_name);
				$dbk = unserialize($string_data);
				
				$pTmp = new Procesos();
				$mTmp = new Mesas();
				$cTmp = new Categorias();
				try{
					$pTmp->limpiarTabla();
				}catch (Exception $e){
					$matrizErr[] = "[" . get_class( $pTmp ) . "] - Limpiando - " . $e->getMessage();
				}
				try{
					$mTmp->deleteByField("id", "0", ">=");
					$mTmp->autoIncrementar(1);
				}catch (Exception $e){
					$matrizErr[] = "[" . get_class( $mTmp ) . "] - Limpiando - " . $e->getMessage();
				}
				$cTmp->deleteByField("talleres_id", $idTaller);
				
				foreach ($dbk as $Clase => $value) {
					$o = new $Clase();					
					$o->autoIncrementar(0);
					foreach ($value as $id => $arrDatos) {
						$m = new $Clase();
						$normal = true;
						
						foreach ($arrDatos as $key => $data) {
							$m->{"set" . Singleton::toCap( $key ) }( $data );
						}
						
						if($m->getId() == 0){
							$normal = false;
						}
						
						if( $normal ){
							$idr = $m->saveData(true);
							$strErr = $m->obtenerError();
							if(strlen( $strErr ) > 0){
								$matrizErr[] = "[" . $Clase . "] " . $strErr;
							}
						}
						
						
					}
				}
			}
		}
		
		return $matrizErr;
		
	}
	
	public function crearBackup(){
		$extbk = ".mem";
		if( isset( $_POST["nombrebk"] ) ){			
			if( strlen( trim( $_POST["nombrebk"] ) ) > 0 ){
				$dirnm = $this->fldbk;
				$flnm = strtolower( str_replace(" ", "_", $_POST["nombrebk"]) );
				
				$nmSoloFl = $dirnm . DIRECTORY_SEPARATOR . $flnm;
				$chkfl = $nmSoloFl . $extbk;
				if(!file_exists( $chkfl )){
					
					$data = array();
					$mesas = new Mesas();
					$categorias = new Categorias();
					$procesos = new Procesos();
					
					$arrMesa = array();
					$tmpMesa = $mesas->readInfo();
					foreach ($tmpMesa as $key => $value) { $arrMesa[] = Utiles::objToArray($value); }
					
					$arrCate = array();
					$tmpCate = $categorias->readInfo();
					foreach ($tmpCate as $key => $value) { $arrCate[] = Utiles::objToArray($value); }
					
					$arrProc = array();
					$tmpProc = $procesos->readInfo();
					foreach ($tmpProc as $key => $value) { $arrProc[] = Utiles::objToArray($value); }
					
					$data["Mesas"] = $arrMesa;
					$data["Categorias"] = $arrCate;
					$data["Procesos"] = $arrProc;
					
					file_put_contents($nmSoloFl . $extbk, serialize($data));
					
				}else{
					throw new Exception("El archivo <b>" . $flnm . "</b> ya existe.");
				}
			}
			else{
				throw new Exception("Campo de nombre vac&iacute;o.");
			}
		}
	}
	
	public static function MkBackUp(){
		$bk = new BackupsCtrl();
		$bk->crearBackup();
	}
	
	public static function UseBackUp(){
		$bk = new BackupsCtrl();
		return $bk->usarBackup();
	}
	
	public static function LimpiarMesas(){
		$erest = array("0" => "Sin limpiar",
				"-1" => "Error"
		);
		
		self::$arrEstadoUp = array();
		if( isset( $_POST["mesas"] ) ){
			$idm = $_POST["mesas"];
			$pr = new Procesos();
			$ret=new Reto();
			$ver = "*";
			$extra = "";
			$ver2="*";
			$extra2="";
			
			if( $idm > 0 ){
				$ver = "*";
				$extra = "where mesas_id = " . $idm;
				$ver2="*";
				$extra2="where id_mesa=".$idm;

			}
			
			
			// Actualiza
			$lsRestart = $pr->readInfo($ver, $extra);
			//Actualiza Reto
			$lsRestart2=$ret->readInfo($ver2,$extra2);
			foreach ($lsRestart as $key => $value) {				
				if($value->getCategorias_id() == 1){
					// Elimina datos de plenaria
					$value->deleteById();
					self::$arrEstadoUp[] = "[DEL] " . $value->getProceso() . ": " . $idUp;
				}else{
					$value->setSugerencia(" ");
					$value->setCategorias_id( "0" );
					$idUp = $value->updateData();
					self::$arrEstadoUp[] = "[UPD] " . $value->getProceso() . ": " . (isset($erest[ $idUp ] ) ? $erest[ $idUp ] : "Limpio");
				}
			}

			foreach ($lsRestart2 as $key => $value) {				

					$value->deleteById();
					self::$arrEstadoUp[] = "[DEL] " . $value->getReto() . ": " . $idUp;
				}
			}


		}
	
	
	public static function restaurarDeFabrica(){
		$file = dirname(dirname(dirname(__FILE__))) . '/def.sql'; // sql data file
		$args = file_get_contents($file); // get contents
		$txt = Singleton::mysqli_import_sql($args);
		
		return $txt;
	}
	
	public function obtenerEstadoLimpiarMesas(){
		return self::$arrEstadoUp;
	}
	
}
?>