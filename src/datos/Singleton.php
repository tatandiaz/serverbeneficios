<?php
header('Content-Type: text/html; charset=UTF-8');
/**
 * Singleton de conexi&oacute;n
 * @author yalfonso
 *
 */
class Singleton {

	//const HOST='inversusacom.ipagemysql.com';
	const HOST='127.0.0.1';
	const DBUSER='root';
	const DBPASS='juan';
	const DBNAME='mqabeneficios';
	
	public static $lnk;
	
	function __construct($host='',$db='',$uname='',$pass=''){
		
		if( !self::$lnk ){
			if($host=='' || $db=='' || $uname='' || $pass=''){
				$host=self::HOST;
				$uname=self::DBUSER;
				$pass=self::DBPASS;
				$db=self::DBNAME;
			}
			
			self::$lnk = new mysqli($host, self::DBUSER, self::DBPASS, self::DBNAME);
			if (self::$lnk->connect_errno) {
			    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
			}else{
				return self::$lnk;
			}
		}else{
			return self::$lnk;
		}

	}

	public static function mysqli_import_sql( $args  ) {
		$dbhost = self::HOST;
		$dbuser = self::DBUSER;
		$dbpass = self::DBPASS;
		$dbname = self::DBNAME;
		
		// check mysqli extension installed
		if( ! function_exists('mysqli_connect') ) {
			die(' This scripts need mysql extension to be running properly ! please resolve!!');
		}
		$mysqli = @new mysqli( $dbhost, $dbuser, $dbpass, $dbname );
		if( $mysqli->connect_error ) {
			print_r( $mysqli->connect_error );
			return false;
	  	}
	    $querycount = 11;
	    $queryerrors = '';
	    $lines = (array) $args;
	    if( is_string( $args ) ) {
			$lines =  array( $args ) ;
	    }
	    if ( ! $lines ) {
			return '' . 'cannot execute ' . $args;
	    }
	    $scriptfile = false;
	    foreach ($lines as $line) {
			$line = trim( $line );
			// if have -- comments add enters
			if (substr( $line, 0, 2 ) == '--') {
				$line = "\n" . $line;
			}
			if (substr( $line, 0, 2 ) != '--') {
				$scriptfile .= ' ' . $line;
				continue;
			}
		}
	    $queries = explode( ';', $scriptfile );
	    foreach ($queries as $query) {
			$query = trim( $query );
			++$querycount;
			if ( $query == '' ) {
				continue;
			}
			if ( ! $mysqli->query( $query ) ) {
				$queryerrors .= '' . 'Line ' . $querycount . ' - ' . $mysqli->error . '<br>';
				continue;
			}
		}
	    if ( $queryerrors ) {
			return '' . 'There was an error SQL: <br>' . $queryerrors;
	    }
	    
	    if( $mysqli && ! $mysqli->error ) {
			@$mysqli->close();
	    }   
	    return 'complete dumping database !';
	}
	
	public static function _arrayToTableReference($arreglo, $campoId = "getId", $campoValor = "getNombre"){
		$tablaReferencia = array();
		foreach ($arreglo as $key => $value) {
			$tablaReferencia[ $value->$campoId() ] = $value->$campoValor();
		}
		return $tablaReferencia;
	}
	
	public static function _metaDatos( $tb ){
		$s = new Singleton();
		$stmt = null;
		$result = array();
		$query = 'SELECT * FROM ' . strtolower($tb) . ' limit 1;';
		if ($stmt = self::$lnk->prepare($query)) {
			$stmt->execute();
			
			$meta = $stmt->result_metadata(); 
			while ($field = $meta->fetch_field()) {
				$result[ $field->name ] = $field->name;
			} 
			
			$stmt->close();
		}else{
			$result["err_info"] = self::$lnk->error;
			return $result;
		}
		return $result;
	}
	/**
	 * Obtiene una lista que contiene una nueva lista con los datos de la consulta
	 * @param ver Campos que quiere ver, ejemplo "ID, COUNT(ID)"
	 * @param extras filtros en SQL, ejemplo: "Where id > 1 AND id < 3"
	 * @return array, retorna un arreglo de datos
	 */
	public static function _readInfo($tb, $ver = "*", $extra = "") {
		$s = new Singleton();
		$fnName = "getId";
		$_id = 1;
		
		$result = array();
		$params = array();
		
		if( $_id > 0 ){
			$stmt = null;
			
			$query = "SELECT " . $ver . " FROM " . $tb . " " . $extra;
			if( $stmt = self::$lnk->prepare($query) ){
				$stmt->execute();
				    
				$meta = $stmt->result_metadata(); 
				while ($field = $meta->fetch_field()) {
					$params[] = &$row[ $field->name ]; 
				}
				call_user_func_array(array($stmt, 'bind_result'), $params); 
				    
				while ($stmt->fetch()) {
				    foreach($row as $key => $val) {
				    	$c[$key] = $val;
				    } 
					$result[] = $c;			        
				} 
	
				$stmt->close();
			}else{
				$result["err_info"] = self::$lnk->error;
				return $result;
			}
		}
		
		return $result;
		
	}
	
	public static function _modelos($jsMenu = false){
		$actualPath = dirname(__FILE__);
		$tmpFold = $actualPath . DIRECTORY_SEPARATOR . "tmpmodelo";
		$tmpFlHtml = $actualPath . DIRECTORY_SEPARATOR . "tmpvistas";
		echo "dir: " . $tmpFold . "<br />";
		$okDir = @mkdir($tmpFold, "0755");
		$okDirHtml = @mkdir($tmpFlHtml, "0755");
		
		if( file_exists( $tmpFold ) ){

			$r = self::_readInfo("INFORMATION_SCHEMA.TABLES", "*", "where TABLE_SCHEMA like '" . self::DBNAME . "'");
			foreach ($r as $id => $vl) {
				$tb = $vl["TABLE_NAME"];
				$md = self::_metaDatos($tb);
				
				$clase = self::toCap( $tb );
				$flname = $clase;
				
				$elHtml = "";
				$txt = "<?php \n";
				$txt .= "/**\n";
	 			$txt .= " *\n";
	 			$txt .= " * @author yalfonso\n";
	 			$txt .= " *\n";
	 			$txt .= " */\n";
				$txt .= "class " . $clase . " extends Clsdatos { \n\n";
				foreach ($md as $key => $value) {
					$vlDef = "\"\"";
					$vlToL = strtolower($value);
					
					$vlHtml = "<input type=\"text\" name=\"" . $vlToL . "[]\" id=\"" . $vlToL . "_x\" class=\"camposEntrada\">";
					if (Utiles::TerminaEn($value, "id")) {
						$vlDef = "0";
						$vlHtml = "Lista datos";
					}
								
					$txt .= "\tprivate \$" . $vlToL . " = " . $vlDef . "; \n";
					
					$elHtml .= "		<table border=\"0\" class=\"tbComun\"> \n";
					$elHtml .= "			<tbody> \n";
					$elHtml .= "				<tr> \n";
					$elHtml .= "					<th><label for=\"" . $vlToL . "_x\">" . self::toCap($value) . "</label></th> \n";
					$elHtml .= "					<td>" . $vlHtml . "</td> \n";
					$elHtml .= "				</tr> \n";
					$elHtml .= "			</tbody> \n";
					$elHtml .= "		</table> \n";
					
				}
				
				$txt .= "\n";
				$elHtmlT = "<form id=\"frmData\" action=\"./\" method=\"post\" > \n";
				$elHtmlT .= "	<div> \n";
				$elHtmlT .= $elHtml;
				$elHtmlT .= "\n	</div> \n";
				
				$elHtmlPHPInf  = "	<input type=\"hidden\" name=\"id[]\" id=\"id_x\" value=\"\" /> \n";
				$elHtmlPHPInf .= "	<input type=\"hidden\" name=\"pageid\" value=\"modelos/<?php echo basename( __FILE__ ); ?>\" /> \n";
				$elHtmlPHPInf .= "	<input type=\"hidden\" name=\"jsmenuid\" value=\"<?php echo \$_POST[ \"jsmenuid\" ]; ?>\" /> \n";
				$elHtmlPHPInf .= "	<input class=\"boton_guardar\" type=\"submit\" name=\"cmd\" value=\"Guardar " . $flname . "\" /> \n";
				
				$elHtmlT .= $elHtmlPHPInf;
				$elHtmlT .= "</form> \n";
				
				$elHtmlT .= "<div id=\"frmVista\" class=\"frmVistaOculta\" > \n";
				$elHtmlT .= "	Sin datos";
				$elHtmlT .= "</div>\n";
				
				foreach ($md as $key => $value) {
					$nmFn = self::toCap( $value );

					$txt .= "\tpublic function get" . $nmFn . " (){ \n";
					$txt .= "\t\treturn \$this->" . $value . ";\n";
					$txt .= "\t} \n";
					
					$txt .= "\tpublic function set" . $nmFn . " ( \$vl ){ \n";
					$txt .= "\t\t\$this->" . $value . " = \$vl;\n";
					$txt .= "\t} \n";
				}
				$txt .= "} \n";
				$txt .= "?>";
				
				if( $jsMenu ){
					echo "pageMenu.agregarMenu( utilidades.appPath(\"img/\") + \"admin_casos.png\",\"" . $flname . "\",\"modelos/" . $flname . ".phtml\"); <br />\n";
				}else{
					$flwr = $tmpFold . DIRECTORY_SEPARATOR . $flname . ".php";
					$flwrHtml = $tmpFlHtml . DIRECTORY_SEPARATOR . $flname . ".phtml";
					echo "escribe php en: " . $flwr . "<br />";
					self::RwFile($flwr, $txt);
					
					echo "escribe html en: " . $flwrHtml . "<br />";
					self::RwFile($flwrHtml, $elHtmlT);
				}
			}			
		}
		
	}
	
	public static function RwFile($flwr, $txt){
		$decF = fopen($flwr, "w");
		fwrite($decF, $txt);
		fclose($decF);
	}
	
	public static function toCap( $str ){
		return strtoupper( substr($str, 0, 1) ) . substr($str, 1, strlen( $str ));
	}
	
	function __destruct(){ 
		if( !self::$lnk ){
			if(method_exists(self::$lnk, 'close')){
				self::$lnk->close();
			}
		}
	}
	
}

?>