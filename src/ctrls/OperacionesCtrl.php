<?php
 header('Content-Type: text/html; charset=UTF-8');
class OperacionesCtrl {

	public static function CargarDatosTbComunes($eliminar = false){
		$dir = dirname( dirname( dirname( __FILE__ ) ) ) . '/src/modelo';
		$dr = Utiles::IncluirArchivos( $dir , true, false);
		$elhash = array();
		$cs = $_POST["cs"];
		foreach ($dr as $key => $value) {
			$elhash[ md5($value) ] = $value;
		}
	
		if( isset($elhash[ $cs ]) ){
			$tb = $elhash[ $cs ];
			$idMd5 = $_POST["obj"];
			$clase = new $tb();
				
			$lsMet = get_class_methods($tb);
			$infoToModify = $clase->readInfo("*","where md5(id) = '" . $idMd5 . "'");
				
			// Eliminar datos
			if( $eliminar ){
				foreach ($infoToModify as $key => $value) {
					$value->deleteById();
				}
				return true;
			}
				
			foreach ($infoToModify as $i => $v) {
				foreach ($lsMet as $key => $value) {
					$busca = "get";
					if( substr($value,0,strlen($busca)) == $busca ){
						$prop = strtolower( substr($value,strlen($busca),strlen($value)) );
						$_POST[ $prop ][] = $v->{ $value }();
					}
				}
			}
		}
	}
	
	// Func Eliminar datos
	public static function EliminarDatosTbComun(){
		return self::CargarDatosTbComunes(true);
	}
	
	public static function CargaMasivaProcesos(){
		$separadores = array("linea" => "\n", ";" => ";");
		$total = 0;
		if( isset( $_POST["nombre"] ) && isset($_POST["separapor"]) ){
			if( strlen(trim($_POST["nombre"])) > 0 ){
				$usrs = explode($separadores[ $_POST["separapor"] ], $_POST["nombre"]);
				$mesa = $_POST["mesas_id"][0];
				
				foreach ($usrs as $key => $value) {
					$usuaa = new Procesos();
					if(strlen( trim($value) ) > 0){
						$usuaa->setProceso( trim($value ) );
						$usuaa->setMesas_id( $mesa );
						$usuaa->setCategorias_id( 0 );
						$usuaa->setFecha( date("Y-m-d h:i:s") );
						$usuaa->setSugerencia( " " );
						$usuaa->setTalleres_id( 1 );
						
						$uok = $usuaa->saveData();
						
						$iErr = $usuaa->obtenerError();
						if( strlen( $iErr ) > 0 ){
							return "Error: " . $iErr ;
						}
						
						if($uok > 0){
							$total++;
						}
					}
				}
				return "Se cargaron " . $total . " procesos.";
			}
		}else{
			return "No envi&ocute; datos v&aacute;lidos.";
		}
	}
	
	public static function RegistrarAuditoriaUsuario($ac, $us, $vl, $pcid){
		$auUsr = new Repauditoria();
		$auUsr->setActividad($ac);
		$auUsr->setFecha(date("Y-m-d h:i:s"));
		$auUsr->setNombre($us);
		$auUsr->setValor($vl);
		$auUsr->setReporte_id($pcid);
		
		$auUsr->saveData();
	}
	
}
?>