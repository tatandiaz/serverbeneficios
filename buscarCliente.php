<?php
require_once("funciones.php");
    
if(isset($_POST['mesa'])){
	
	$municipios = dameMunicipio($_POST['mesa']);
	
	$html = "<option value=''> Seleccione el proceso </option>";
	foreach($municipios as $indice => $registro){
		$html .= "<option value='".$registro['id']."  ".$registro['proceso']."'>".$registro['proceso']."</option>";
	}
	
	$respuesta = array("html"=>$html);
	echo json_encode($respuesta);
}



?>