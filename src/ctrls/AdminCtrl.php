<?php
 header('Content-Type: text/html; charset=UTF-8');
class AdminCtrl extends Pagina {
	
	const TALLER_DEFECTO = 1; 
	
	public function __construct(){
		//echo "Inicio";
	}
	
	public function obtenerTiposCategoria($def = 1){
		return self::obtenerListaHtml("Tiposcategoria", "tiposcategoria_id", "", $def, "where id < 3", "nombre", "lstTipoDeCate");
	}
	
	public function obtenerTiposCatEnArreglo(){
		$catI = array();
		$a = self::obtenerListado("Tiposcategoria", "*", "");
		foreach ($a as $key => $value) {
			$catI[$value["id"]] = $value;
		}
		return $catI;
	}
	
	public function obtenerRefDeCategorias(){
		$catI = array();
		$a = self::obtenerListado("Categorias", "*", "order by orden");
		foreach ($a as $key => $value) {
			$catI[$value["id"]] = $value;
		}
		return $catI;
	}
	
	public function obtenerCategorias(){
		return self::obtenerListado("Categorias", "*", "where id > 1 order by orden");
	}
	
	public static function CrearTaller() {
		$proce = new Procesos();
		$proce->limpiarTabla();
		
		$arrErr = array();
		
		if(isset( $_POST["frmd"] )){
			$o = json_decode( $_POST["frmd"] );
			if( !(json_last_error() == JSON_ERROR_NONE) ){
				$o = json_decode( str_replace("\\", "", $_POST["frmd"]) );
			}
			
			if( property_exists($o, "Mesa") ){
				$mesas = new Mesas();
				$mesas->deleteByField("id", "0", ">=");
				$mesas->autoIncrementar(1);
				unset( $mesas );
				foreach ($o->Mesa as $kMesa => $vMesa) {
					$mesa = new Mesas();
					$mesa->setNombre( $vMesa->nombre );
					$mesa->setVisiblesugerencias( 0 );
					$mesa->setTalleres_id( self::TALLER_DEFECTO );
					$mesa->saveData();
					
					$tmpE = $mesa->obtenerError();
					if ( strlen( $tmpE ) > 0  ) {
						$arrErr[ ] = "[Mesas] " . $tmpE;
					}
					unset( $mesa );
				}
				
			}
			
			// Creación de Categorías
			if( property_exists($o, "Categorias") ){
				$categ = new Categorias();
				$categ->deleteByField("id", "1", ">");
				$categ->autoIncrementar(2);
				$tmpDep = array();
				
				unset( $categ );
				foreach ($o->Categorias as $kCat => $vCat) {
					$nombre = utf8_decode( $vCat->nombre );
					
					$c = new Categorias();
					$c->setTalleres_id( self::TALLER_DEFECTO );
					$c->setNombre( $nombre );
					$c->setColor( $vCat->color );
					$c->setDependencia( ( isset( $tmpDep[ $vCat->dependencia ] ) ? $tmpDep[ $vCat->dependencia ] : 0 ) );
					$c->setTiposcategoria_id( $vCat->tiposcategoria_id );
					$c->setOrden($vCat->orden);
					
					$tmpDep[ $nombre ] = $c->saveData();
						
					$tmpE = $c->obtenerError();
					if ( strlen( $tmpE ) > 0  ) {
						$arrErr[ ] = "[Categorias] " . $tmpE;
					}
					unset( $c );
				}
				//print_r( $tmpDep );
			}
		}
		
		return $arrErr;
	}
	
}
?>