<?php    
/*
 * PHP QR Code encoder
 *
 * Exemplatory usage
 *
 * PHP QR Code is distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */
class Infoqr{
	
	const NIVEL = 'L';
	const DIMENSION = 4;
	const RESUMEN = 'Sin datos';
	
	private $PNG_TEMP_DIR = '';
	const PNG_WEB_DIR = 'temp/';
	
	private $_resumen = "";
	
	public function __construct(){
		$this->PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;
		if (!file_exists($this->PNG_TEMP_DIR))
        	mkdir($this->PNG_TEMP_DIR);
	}
	
	public function Iniciar(){
		include_once "qrlib.php";
	    $filename = $this->PNG_TEMP_DIR . 'test.png';
	    
	    $errorCorrectionLevel = self::NIVEL;
	    if (isset($_POST['level']) && in_array($_POST['level'], array('L','M','Q','H')))
	        $errorCorrectionLevel = $_POST['level'];    

	    $matrixPointSize = self::DIMENSION;
	    if (isset( $_POST['size'] ))
	        $matrixPointSize = min(max((int)$_POST['size'], 1), 10);
	        
	    
	    if (isset($_POST['data'])) {
	        if (trim($_POST['data']) == '')
	            die('-');

	        $filename = $this->PNG_TEMP_DIR. 'test' . md5( $_POST['data'] . '|' . $errorCorrectionLevel. '|' . $matrixPointSize ). '.png';
	        QRcode::png( $_POST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);
	    } else {    
	        QRcode::png( self::RESUMEN , $filename, $errorCorrectionLevel, $matrixPointSize, 2);
	    }

	    return self::PNG_WEB_DIR . basename($filename);
	}
}  

?>