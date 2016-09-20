<?php
 header('Content-Type: text/html; charset=UTF-8');
class MenuTortasCtrl extends Pagina {
		
	public function __construct(){
		//echo "Inicio";
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
	
	public function pastelInicial($def = ""){
		$ver = "*";
		$extra = "";
		
		if(strlen($def) > 0){
			$extra = "where mesas_id = " . $def;
		}
		
		$nwCol = array();
		$base = Pagina::obtenerListado("Vwpregxmesa", $ver, $extra);
		foreach ($base as $key => $value) {
			$bsC = $this->getColor($key * 10);
			$nwCol[] = array(
					"value" => $value["total"],
					"color" => "#" . $bsC["r"] . $bsC["g"] . $bsC["b"],
					"label" => $value["nombre"]
					);
		}   
		return $nwCol;
	}
	public function obtenerDatosTortas(){
		$mesaid = $_POST["mesas"];
		$ver = "*";
		$extra = "where mesas_id = " . $mesaid . " and categorias_id > 0";	// no muestra los q están en 0
		if( $mesaid == 0){
			$ver = "categorias_id, sum(votados) as votados, mesas_id, nombre, dependencia, color";
			$extra = "group by categorias_id";
		}
		$nwCol = array();
		$base = Pagina::obtenerListado("Vwvotados", $ver, $extra);
		foreach ($base as $key => $value) {
			$bsC = $this->getColor($key * 10);
			$nwCol[] = array(
					"value" => $value["votados"],
					"color" => $value["color"],
					"label" => mb_convert_encoding($value["nombre"], "UTF-8", "ISO-8859-1")
			);
		}
		return $nwCol;
	} 
	public function obtenerDatosTablero($id){
		$c = new Categorias();
		$res1 = $c->readInfo("*", "");
		$p = new Procesos();
		$res2 = $p->readInfo( "*", "where mesas_id = " . $id . " and categorias_id > 0" );
		return array( "r1" => $res1, "r2" => $res2 );
	}
	public function getColor($num) {
	    $hash = md5('color' . $num); // modify 'color' to get a different palette
	    return array(
	    		"r" => (substr($hash, 0, 2)), // r
	    		"g" => (substr($hash, 2, 2)), // g
	    		"b" => (substr($hash, 4, 2))); //b
	}
}
?>