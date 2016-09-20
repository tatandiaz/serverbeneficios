<?php
 header('Content-Type: text/html; charset=UTF-8');
class Pagina {
	
	const REGISTROS_PAGINA = 30;
	
	private $mensaje = "";
	private $subfolders = "";
	
	public function setMensaje( $vl ) { $this->mensaje = $vl; }
	public function getMensaje( ) { return $this->mensaje; }
	
	/**
	 * 
	 * Imprime una tabla HTML con los datos de una consulta a una tabla en la base de datos.<br />
	 * Si la tabla en la base de datos tiene llaves foraneas es posible indicar las dependencias y tambi&eacute;n es posible 
	 * personalizar los r&oacute;tulos de las tablas
	 * @param Object $clase, el modelo de datos que se va a imprimir como tabla HTML
	 * @param Array $rotulos, arreglo que contiene en su llave el nombre del r&oacute;tulo que se va a reemplazar y en su valor el nuevo r&oacute;tulo.<br />Ejemplo: array('id' => 'Mi ID') 
	 * @param Array $foraneos, arreglo que los valores foraneos de las tablas de referencia
	 * @param String $ver, vista SQL. Ejemplo "*"
	 * @param String $extra, filtros SQL. Ejemplo: "Where id > 3" 
	 * @param Int $pagina, n&uacute;mero de p&aacute;gina
	 * @param Int $cantidad, n&uacute;mero de registros en cada p&aacute;gina 
	 */
	public static function obtenerTablaHtml($clase, $rotulos = array(), $foraneos = array(), $ver = "*", $extra = "", $pagina = 0, $cantidad = self::REGISTROS_PAGINA, $clase2 = null){
		$pagina = ($pagina < 0 ? 0 : $pagina);
		$arrTb = self::obtenerListado( $clase, $ver, $extra, $pagina, $cantidad );
		$tabla = '<table>';
		$encabezados = '';
		$cuerpo = '';
		if( sizeof( $arrTb ) > 0 ){
			
			$encabezados .= '	<thead>';
			$encabezados .= '		<tr> ';
			$arrHd = array_keys($arrTb[0]);
			
			foreach ( $arrHd as $idH => $vlH ){
				$rt = $vlH;
				if( is_array( $rotulos ) ){
					if( isset( $rotulos[ $vlH ] ) ){
						$rt = $rotulos[ $vlH ];
					}
				}
				
				$encabezados .= '			<th>' . $rt . '</th> ';
			}
			$encabezados .= '		</tr> ';
			$encabezados .= '	</thead> ';
			
			$cuerpo .= '<tbody>';
			foreach ($arrTb as $idB => $vlB) {
				$cuerpo .= '<tr>';
				
				foreach ($vlB as $idCuerpo => $vlCuerpo ) {
					$txtDef = $vlCuerpo;
					if( isset( $foraneos[ $idCuerpo ] ) ){
						$tmpField = $foraneos[ $idCuerpo ];
						if( isset( $tmpField[ $vlCuerpo ] ) ){
							$txtDef = $tmpField[ $vlCuerpo ];
						}
					}
					
					$strPrint = $txtDef;
					
					if( strtolower( $idCuerpo ) == "id" ){
							
						$jsmenuid = (isset($_POST[ "jsmenuid" ]) ? $_POST[ "jsmenuid" ]: "");
							
						$cuerpo .= '<td >';						
						$cuerpo .= '	<table>';
						$cuerpo .= '		<tbody>';
						$cuerpo .= '			<tr>';
						$cuerpo .= '				<td>';
						
						$cuerpo .= '	<form action="./" method="post" id="dtView_' . $strPrint . '" >';
							
						if( isset( $vlB[ "estado_id" ] ) ){
							if( $vlB["estado_id"] == "1"){
								$cuerpo .= '		<input type="submit" value="&nbsp;" class="dtViewVisible" />';
								$cuerpo .= '		<input type="hidden" name="ide" value="' . md5( 2 ) . '" />';
							}else if( $vlB["estado_id"] == "2"){
								$cuerpo .= '		<input type="submit" value="&nbsp;" class="dtViewInVisible" />';
								$cuerpo .= '		<input type="hidden" name="ide" value="' . md5( 1 ) . '" />';
							}
							$cuerpo .= '		<input type="hidden" name="cmd" value="' . md5("estadoinactivo") . '" />';
						}
						else{
							//$cuerpo .= '		<input type="submit" class="dtViewEdit" value="' . $strPrint . '" />';
							$cuerpo .= '		<input type="submit" class="dtViewEdit" value="&nbsp;" />';
							$cuerpo .= '		<input type="hidden" name="cmd" value="' . md5("modificarfrm") . '" />';
						}
							
						$cuerpo .= '		<input type="hidden" name="cs" value="' . md5( ( $clase2 == null ? $clase : $clase2 ) ) . '" />';
						$cuerpo .= '		<input type="hidden" name="obj" value="' . md5($strPrint) . '" />';
						$cuerpo .= '		<input type="hidden" name="pageid" value="' . $_POST["pageid"] . '" />';
						$cuerpo .= '		<input type="hidden" name="jsmenuid" value="' . $jsmenuid . '" />';
						
						$cuerpo .= '	</form>';
						
						$cuerpo .= '				</td>';
						$cuerpo .= '				<td>';
						// Eliminar
						$cuerpo .= '	<form action="./" method="post" id="dtDelView_' . $strPrint . '" >';
						$cuerpo .= '		<input type="submit" class="dtViewDel" value="&nbsp;" />';
						$cuerpo .= '		<input type="hidden" name="cmd" value="' . md5("eliminarfrm") . '" />';
						
						$cuerpo .= '		<input type="hidden" name="cs" value="' . md5( ( $clase2 == null ? $clase : $clase2 ) ) . '" />';
						$cuerpo .= '		<input type="hidden" name="obj" value="' . md5($strPrint) . '" />';
						$cuerpo .= '		<input type="hidden" name="pageid" value="' . $_POST["pageid"] . '" />';
						$cuerpo .= '		<input type="hidden" name="jsmenuid" value="' . $jsmenuid . '" />';
						
						$cuerpo .= '	</form>';
						
						$cuerpo .= '				</td>';
						$cuerpo .= '			</tr>';
						$cuerpo .= '		</tbody>';
						$cuerpo .= '	</table>';
						
						$cuerpo .= '</td>';
						
						/*$cuerpo .= '	<form action="./" method="post" id="dtView_' . $strPrint . '" >';
							
						if( isset( $vlB[ "estado_id" ] ) ){
							if( $vlB["estado_id"] == "1"){
								$cuerpo .= '		<input type="submit" value="&nbsp;" class="dtViewVisible" />';
								$cuerpo .= '		<input type="hidden" name="ide" value="' . md5( 2 ) . '" />';
							}else if( $vlB["estado_id"] == "2"){
								$cuerpo .= '		<input type="submit" value="&nbsp;" class="dtViewInVisible" />';
								$cuerpo .= '		<input type="hidden" name="ide" value="' . md5( 1 ) . '" />';
							}
							$cuerpo .= '		<input type="hidden" name="cmd" value="' . md5("estadoinactivo") . '" />';
						}
						else{
							//$cuerpo .= '		<input type="submit" class="dtViewEdit" value="' . $strPrint . '" />';
							$cuerpo .= '		<input type="submit" class="dtViewEdit" value="&nbsp;" />';
							$cuerpo .= '		<input type="hidden" name="cmd" value="' . md5("modificarfrm") . '" />';
						}
							
						$cuerpo .= '		<input type="hidden" name="cs" value="' . md5( ( $clase2 == null ? $clase : $clase2 ) ) . '" />';
						$cuerpo .= '		<input type="hidden" name="obj" value="' . md5($strPrint) . '" />';
						$cuerpo .= '		<input type="hidden" name="pageid" value="' . $_POST["pageid"] . '" />';
						$cuerpo .= '		<input type="hidden" name="jsmenuid" value="' . $jsmenuid . '" />';

						$cuerpo .= '	</form>';
						$cuerpo .= '</td>';*/
					}else{
						$cuerpo .= '<td>' . $strPrint . '</td>';
					}
					
				}
				
				$cuerpo .= '</tr>';
			}
			$cuerpo .= '</tbody>';
		}
		$tabla .= $encabezados . $cuerpo . "</table>";
		return $tabla;
	}
	
	/**
	 * 
	 * Obtiene un arreglo de datos
	 * @param Object $clase, el modelo de datos que se va a imprimir como tabla HTML
	 * @param String $ver, vista SQL. Ejemplo "*"
	 * @param String $extra, filtros SQL. Ejemplo: "Where id > 3" 
	 * @param Int $pagina, n&uacute;mero de p&aacute;gina
	 * @param Int $cantidad, n&uacute;mero de registros en cada p&aacute;gina 
	 *
	 */
	public static function obtenerListado($clase, $ver, $extra, $pagina = 0, $cantidad = self::REGISTROS_PAGINA){
		
		$txt = array();
		if( Seguridad::isLogin() ){
			$oQuery = new $clase();
			
			$desde = strrpos(strtolower( $extra ), "limit");
			$txtExtraFiltro = substr($extra, 0, $desde );
			
			$query = $oQuery->readInfo( $ver, $extra . ' Limit ' . ($pagina * $cantidad) . ', ' . $cantidad );
			foreach ( $query as $key => $value ) {
				$cl = get_class_methods( get_class( $value ) );
				$miembros = array();
				foreach ($cl as $id => $vl ) {
					if( substr($vl, 0, 3) == "get" ){
						$tNameMth = str_replace("get", "", $vl);
						$tmpV = $value->$vl();
						$miembros[ strtolower( $tNameMth ) ] = ( $tmpV );
					}
				}
				$txt[] = $miembros;
			}
		}
		
		return $txt;
	}
	
	/**
	 * 
	 * Renderiza el objeto SELECT permitiendo traer datos de referencia o llaves foraneas
	 * @param String $clase, Nombre de la clase que contiene los datos
	 * @param String $nombreLs, Nombre que se le va a poner a el campo Select
	 * @param String $idLs, Nombre del campo Id
	 * @param String $metodoGetNombre, Nombre del m&eacute;todo en la entidad que permite imprimir el nombre de la opci&oacute;n
	 * @param Integer $seleccionado, Id del item seleccionado si se necesitara alg&uacute;n valor espec&iacute;fico por defecto
	 * @param String $estilo, Nombre del estilo que se le aplicar&aacute; al elemento Select
	 */
	public static function obtenerListaHtml( $clase, $nombreLs, $idLs, $seleccionado = "1", $extra = "", $metodoGetNombre = "nombre", $estilo = "" ){
		$objLs = new $clase();
		$lsPerfil = $objLs->readInfo("*",$extra);
		$txt = '<select name="' . $nombreLs . '" id="' . $idLs . '" class="' . $estilo . '" >';
		foreach ($lsPerfil as $key => $value) {
			$sopti = "";
			if ($seleccionado == $value->getId()) {
				$sopti = ' selected="selected" ';
			}
			$txt .= '<option value="' . $value->getId() . '"' . $sopti . '>' . $value->{ "get" . Singleton::toCap( $metodoGetNombre ) }() . '</option>';
		}
		$txt .= "</select>";
		return $txt;
	}
	
	/**
	 * 
	 * Este metodo asigna un texto al mensaje cuando se intentan guardar datos en alg&uacute;n modelo
	 * @param String $clase, Nombre de la clase que va a salvar datos
	 * @param String $valorRq, Valor que lleva el comando env&iacute;ado por el m&eacute;todo POST, GET &oacute; REQUEST
	 * @return String, Devuelve un estado seg&uacute;n la operaci&oacute;n
	 */
	public static function mensajePlano($clase, $valorRq) {
		if( isset( $_POST["cmd"] ) ){
			if( $_POST["cmd"] == $valorRq ) {
				$clase = $clase;
				$ocls = new $clase();
				$totalOk = 0;
				$allOk = true;
				$svData = $ocls->saveDataFromPost();
				foreach ($svData as $key => $value) {
					if( $value > 0 ){
						$totalOk++;
					}else{
						$allOk = false;
					}
				}
				
				if( $allOk ){
					return "Todos los registros fueron guardados con &eacute;xito.";
				}else if(!$allOk && $totalOk > 0){
					$regErr = print_r($_POST["cmd"], true);
					return 'Algunos registros no fueron salvados. ' . $regErr;
				}else{
					return "Ninguno de los elementos pudo ser salvado.";
				}
			}
		}
	}
	
	/**
	 * 
	 * Este metodo asigna un texto al mensaje cuando se intentan guardar datos en alg&uacute;n modelo
	 * @param String $clase, Nombre de la clase que va a salvar datos
	 * @param String $valorRq, Valor que lleva el comando env&iacute;ado por el m&eacute;todo POST, GET &oacute; REQUEST
	 * @param Object $instanciaPage, Objeto que extiende de un tipo Pagina
	 */
	public static function mensajeComun($clase, $valorRq, $instanciaPage) {
		if( isset( $_POST["cmd"] ) ){
			if( $_POST["cmd"] == $valorRq ) {
				
				$clase = $clase;
				$ocls = new $clase();
				$totalOk = 0;
				$allOk = true;				
				$svData = $ocls->saveDataFromPost();
				foreach ($svData as $key => $value) {
					if( $value > 0 ){
						$totalOk++;
					}else{
						$allOk = false;
					}
				}
				if( $allOk ){
					$instanciaPage->setMensaje("Todos los registros fueron guardados con &eacute;xito.");
				}else if(!$allOk && $totalOk > 0){
					$regErr = print_r($_POST["cmd"], true);
					$instanciaPage->setMensaje('Algunos registros no fueron salvados. <pre>' . $regErr . '</pre>');
				}else{
					$instanciaPage->setMensaje("Ninguno de los elementos pudo ser salvado.");
				}
				
				return $svData;
			}
		}
	}
	
	/**
	 * Crea los campos necesarios para ingresar la fecha correctamente 
	 * @param string $nombre Nombre del campo
	 * @param string $id Id del campo
	 * @param string $defecto Valor por defecto que se cargar&aacute; en el campo
	 * @param string $estiloClase Clase de estilos que tendr&aacute; la tabla
	 * @param string $conNom Agregar nombre a los campos
	 * @return string
	 */
	public static function componenteFecha( $nombre, $id, $defecto = "0000-00-00", $estiloClase = "", $conNom = false ){
		if( $defecto == "0000-00-00" ){
			$defecto = date("Y-m-d");
		}
		
		$actual = strtotime($defecto);
		$newformat = date('Y-m-d',$actual);
		$defecto = $newformat;
		$anyo = date('Y',$actual);
		$mes = date('m',$actual) * 1;
		$dia = date('d',$actual) * 1;
		
		$ai = "a_" . $id;
		$mi = "m_" . $id;
		$di = "d_" . $id;
		
		$ani = ( $conNom ? " name=\"a_" . $nombre . "\"" : "");
		$mni = ( $conNom ? " name=\"m_" . $nombre . "\"" : "");
		$dni = ( $conNom ? " name=\"d_" . $nombre . "\"" : "");
		
		$jsCom  = "onkeyup=\"ut.ComponenteFecha('#" . $id . "', '#" . $ai . "', '#" . $mi . "', '#" . $di . "');\" ";
		$jsCom .= "onchange=\"ut.ComponenteFecha('#" . $id . "', '#" . $ai . "', '#" . $mi . "', '#" . $di . "');\"";
		
		$selAnyo  = "<select " . $jsCom . $ani . " id=\"" . $ai . "\" style=\"width: 55px;\" >";
		for ($i = ($anyo - 1); $i < date('Y', strtotime('+10 year')); $i++) {
			$sel = ($i == $anyo ? "selected=\"selected\" " : "");
			$selAnyo .= "<option " . $sel . "value=\"" . $i . "\">" . $i . "</option>";
		}
		$selAnyo .= "</select>";
		
		$selMes  = "<select " . $jsCom . $mni . " id=\"" . $mi . "\" style=\"width: 40px;\" >";
		for ($i = 1; $i <= 12; $i++) {
			$vlMes = (strlen( $i ) == 1 ? "0" . $i : $i );
			$sel = ($i == $mes ? "selected=\"selected\" " : "");
			$selMes .= "<option " . $sel . "value=\"" . $vlMes . "\">" . $vlMes . "</option>";
		}
		$selMes .= "</select>";
		
		$selDia  = "<select " . $jsCom . $dni . " id=\"" . $di . "\" style=\"width: 40px;\" >";
		for ($i = 1; $i <= 31; $i++) {
			$vlMes = (strlen( $i ) == 1 ? "0" . $i : $i );
			$sel = ($i == $dia ? "selected=\"selected\" " : "");
			$selDia .= "<option " . $sel . "value=\"" . $vlMes . "\">" . $vlMes . "</option>";
		}
		$selDia .= "</select>";
		
		
		$html  = "<table class=\"" . $estiloClase . "\" >";
		$html .= "	<tbody>";
		$html .= "		<tr>";
		$html .= "			<th><label for=\"" . $ai . "\">A&ntilde;o</label></th>";
		$html .= "			<th><label for=\"" . $mi . "\">Mes</label></th>";
		$html .= "			<th><label for=\"" . $di . "\">D&iacute;a</label></th>";
		$html .= "		</tr>";
		$html .= "		<tr>";
		$html .= "			<td>" . $selAnyo . "</td>";
		$html .= "			<td>" . $selMes . "</td>";
		$html .= "			<td>" . $selDia . "</td>";
		$html .= "		</tr>";
		$html .= "	</tbody>";
		$html .= "</table>";
		$html .= "<input type=\"hidden\" name=\"" . $nombre . "\" id=\"" . $id . "\" value=\"" . $defecto. "\" />";
		return $html;
	}
	
	/**
	 * Crea los campos necesarios para ingresar la hora correctamente
	 * @param String $nombre Nombre del campo
	 * @param String $id Id del campo
	 * @param string $defecto Valor por defecto que se cargar&aacute; en el campo
	 * @param string $estiloClase Clase de estilos que tendr&aacute; la tabla
	 * @return string
	 */
	public static function componenteHora( $nombre, $id, $defecto = "00:00", $estiloClase = "", $conNom = false  ){
		if( $defecto == "00:00" ){
			$defecto = date("H:i");
		}
		$actual = strtotime($defecto);
		$newformat = date('H:i',$actual);
		$defecto = $newformat;
		$hora = date('H',$actual);
		$minu = date('i',$actual);
	
		$hi = "h_" . $id;
		$mi = "m_" . $id;
	
		$hni = ( $conNom ? " name=\"h_" . $nombre . "\"" : "");
		$mni = ( $conNom ? " name=\"m_" . $nombre . "\"" : "");
		
		$jsCom  = "onkeyup=\"ut.ComponenteHora('#" . $id . "', '#" . $hi . "', '#" . $mi . "');\" ";
		$jsCom .= "onchange=\"ut.ComponenteHora('#" . $id . "', '#" . $hi . "', '#" . $mi . "');\"";
	
		
		$selHora  = "<select " . $jsCom . $hni . " id=\"" . $hi . "\" style=\"width: 40px;\" >";
		for ($i = 0; $i <= 23; $i++) {
			$vlHor = (strlen( $i ) == 1 ? "0" . $i : $i );
			$sel = ($i == $hora ? "selected=\"selected\" " : "");
			$selHora .= "<option " . $sel . "value=\"" . $vlHor . "\">" . $vlHor . "</option>";
		}
		$selHora .= "</select>";
		
		$selMinu  = "<select " . $jsCom . $mni . " id=\"" . $mi . "\" style=\"width: 40px;\" >";
		for ($i = 0; $i <= 59; $i++) {
			$vlMin = (strlen( $i ) == 1 ? "0" . $i : $i );
			$sel = ($i == $minu ? "selected=\"selected\" " : "");
			$selMinu .= "<option " . $sel . "value=\"" . $vlMin . "\">" . $vlMin . "</option>";
		}
		$selMinu .= "</select>";
	
		$html  = "<table class=\"" . $estiloClase . "\" >";
		$html .= "	<tbody>";
		$html .= "		<tr>";
		$html .= "			<th><label for=\"" . $hi . "\">Hora</label></th>";
		$html .= "			<th><label for=\"" . $mi . "\">Minutos</label></th>";
		$html .= "		</tr>";
		$html .= "		<tr>";
		$html .= "			<td>" . $selHora . "</td>";
		$html .= "			<td>" . $selMinu . "</td>";
		$html .= "		</tr>";
		$html .= "	</tbody>";
		$html .= "</table>";
		$html .= "<input type=\"hidden\" name=\"" . $nombre . "\" id=\"" . $id . "\" value=\"" . $defecto. "\" />";
		return $html;
	}
	
	/**
	 * 
	 * Asigna un subfolder a la vista, si el modelo est&aaacute; en un subfolder
	 * @param String $param ruta de las subcarpetas
	 */
	public function setSubfolders($param) {
		$this->subfolders = $param;
	}
	
	/**
	 * 
	 * Muestra el perfil actual del usuario
	 * @return String, id del perfil
	 */
	public function estePerfil(){
		if (isset( $_SESSION["usu"] )) {
			$usu = $_SESSION["usu"];
			return $usu->getPerfilusuarios_id();
		}
		return "";
	}
	
	public function render(){
		$url_base = dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . "tpls" . DIRECTORY_SEPARATOR;
		$flTplFile = pathinfo( $url_base . get_class( $this ) . ".php" );
		$fullPath = $url_base . $this->subfolders . str_replace("Ctrl", "", $flTplFile[ "filename" ]) . ".phtml";
		if( file_exists($fullPath) ){
			include_once $fullPath;
		}
	}
	
}
?>