<?php
 header('Content-Type: text/html; charset=UTF-8');
class MenuJson{
	
	public function jsonItemList($idPrimeroEnMostrar, $retJson = false){
		// Menu Items
		$vwmenuitems = new Vwmenuitems();
		$verMi = "*";

		$donde = "WHERE tipo = " . $idPrimeroEnMostrar . " ";
		//$donde = "WHERE tipo = 14 ";
		$agrupa = "";
		$orden = "order by idmenu asc";
		$extraMi = $donde . $agrupa . $orden;
		
		$miListObj = $vwmenuitems->readInfo($verMi, $extraMi);
		
		$tmpGrp = array();
		$precios = array();
		foreach ($miListObj as $key => $value) {
			
			$precios[ $value->getIdmenu() ][] = array(
					"idprecio" => $value->getIdprecio()
					,"rotulosprecios_id" => $value->getRotulosprecios_id()
					,"rotulo" => $value->getRotulo()
					,"valor" => $value->getValor()
			);
			
			if ( !isset( $tmpGrp[ $value->getIdmenu() ] ) ){
				$arrT["idmenu"] = 			$value->getIdmenu();
				$arrT["nombre"] = 			$value->getNombre();
				$arrT["descripcion"] = 		mb_convert_encoding($value->getDescripcion(), "UTF-8", "ISO-8859-1");
				$arrT["imagen"] = 			$value->getImagen();
				$arrT["tipo"] = 			$value->getTipo();
				$arrT["precio"] = 			array();
					
				$tmpGrp[ $value->getIdmenu() ] = $arrT;
			}
		}
		
		foreach ($precios as $key => $value) {
			$tmpGrp[ $key ]["precio"] = $value;
		}
		
		if ($retJson) {
			header('Content-Type: application/json');
			return json_encode($tmpGrp, JSON_HEX_AMP);
		}else{
			return $tmpGrp;
		}
		
	}
	
	public function jsonListaMenu(){
		header('Content-Type: application/json');
		$vwLm = new Vwlistamenu();
		$ver = "*";
		$extra = "";
		$lista = $vwLm->readInfo($ver, $extra);
		
		$arrJson = array();
		$primero = true;
		$idPrimeroEnMostrar = 0;
		foreach ($lista as $id => $vl){
			$arrJson[] = Utiles::objToArray($vl);
			
			if ($primero){
				$idPrimeroEnMostrar = $vl->getId();
				$primero = false;
			}
			
		}
		
		$arrDatosIni["lista"] = $arrJson;
		$arrDatosIni["items"] = $this->jsonItemList( $idPrimeroEnMostrar );
		
		return json_encode( $arrDatosIni );
	}
	
}
?>