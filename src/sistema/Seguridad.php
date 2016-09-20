<?php
 header('Content-Type: text/html; charset=UTF-8');
class Seguridad{
		
	private static $YALE =  "PUFzJSYvKCkhsEdoX2Zqa2RoZmxvQH5eey8qLTI0QCM=";
	private static $ROKIE = "OWFqQVNqa2o9a2slIyFAZH19YGRAZC8qLWAnPz1hvyY=";
	
	public static function loginAdmin($usr, $pwd, $creasesion = true){
		
		if( !$creasesion ){
			$usuarios = new Usuarios();
			$u = $usr;
			$p = $pwd;
			$strf = "where (md5(usuario) = '" . $u . "' and clave = '" . $p . "') or (md5(mail) = '" . $u . "' and clave = '" . $p . "')";
			$objRes = $usuarios->readInfo("*",$strf);
			if(sizeof($objRes) > 0 ){
				return true;
			}
			return false;
		}
		
		if( $usr == Config::USU_ADM && md5( $pwd ) == Config::PAS_ADM ){
			if ( !$_SESSION ){ @session_start(); }
			$usuario = new Usuarios();
			
			$usuario->setId( 0 );
			$usuario->setNombres("Usuario");
			$usuario->setApellidos("Root");
			$usuario->setMail("admin@" . $_SERVER["SERVER_NAME"] );
			$usuario->setPerfilusuarios_id(0);
			$usuario->setEstado_id(0);
			$usuario->setUsuario( $usr );
			$usuario->setClave( md5( $pwd ) );
			$usuario->setCreado( date("Y-m-d H:i:s") );
				
			$_SESSION["usu"] = $usuario;
			return true;
		}else{
			
			$usuarios = new Usuarios();
			$strf = "where (usuario = '" . $usr . "' and clave = '" . md5($pwd) . "') or (mail = '" . $usr . "' and clave = '" . md5($pwd) . "')";
			$objRes = $usuarios->readInfo("*",$strf);
			
			if(sizeof($objRes) > 0 ){
				$_SESSION["usu"] = $objRes[0];
				return true;
			}
			
			return false;
		}
	}
	
	public static function logout(){
		unset( $_SESSION["usu"] );
		session_destroy();
	}
	
	public static function isLogin(){
		if( isset( $_SESSION[ "usu" ] ) ) {
			return true;
		}else{
			return false;
		}
	}
	
	private static function addpadding($string, $blocksize = 32)
	{
	    $len = strlen($string);
	    $pad = $blocksize - ($len % $blocksize);
	    $string .= str_repeat(chr($pad), $pad);
	    return $string;
	}
	
	private static function strippadding($string)
	{
	    $slast = ord(substr($string, -1));
	    $slastc = chr($slast);
	    $pcheck = substr($string, -$slast);
	    if(preg_match("/$slastc{".$slast."}/", $string)){
	        $string = substr($string, 0, strlen($string)-$slast);
	        return $string;
	    } else {
	        return false;
	    }
	}
	
	public static function Establece($string = "")
	{   
		return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, base64_decode( self::$YALE ), Seguridad::addpadding($string), MCRYPT_MODE_CBC, base64_decode( self::$ROKIE)));
	}
	
	public static function Obtiene($string = "")
	{
		$string = base64_decode($string);
		return Seguridad::strippadding(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, base64_decode( self::$YALE ), $string, MCRYPT_MODE_CBC, base64_decode( self::$ROKIE )));
	}
	
	public static function ElHash($cl, $id, $nombre = "nombre"){
		$clase = Singleton::toCap($cl);
		if(class_exists( $clase )){
			$c = new $clase();
			$vl = $c->readInfo("*", "where md5(id) = '" . $id . "'"); 
			return $vl[0]->{"get" . Singleton::toCap( $nombre ) }();
		}
		return "";
	}
	
}
?>