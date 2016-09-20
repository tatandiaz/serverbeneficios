<?php

/* Archivo para funciones */

function conectaBaseDatos(){
	try{
		$servidor = "localhost";
		$basedatos = "mqabeneficios";
		$usuario = "root";
		$contrasena = "juan";
	
		$conexion = new PDO("mysql:host=$servidor;dbname=$basedatos",
							$usuario,
							$contrasena,
							array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		
		$conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		return $conexion;
	}
	catch (PDOException $e){
		die ("No se puede conectar a la base de datos". $e->getMessage());
	}
}

function dameEstado(){
	$resultado = false;
	$consulta = "SELECT * FROM mesas";
	
	$conexion = conectaBaseDatos();
	$sentencia = $conexion->prepare($consulta);
	
	try {
		if(!$sentencia->execute()){
			print_r($sentencia->errorInfo());
		}
		$resultado = $sentencia->fetchAll();
		//$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		$sentencia->closeCursor();
	}
	catch(PDOException $e){
		echo "Error al ejecutar la sentencia: \n";
			print_r($e->getMessage());
	}
	
	return $resultado;
}

function dameMunicipio($estado = ''){
	$resultado = false;
	$consulta = "SELECT * FROM procesos";
	
	if($estado != ''){
		$consulta .= " WHERE mesas_id = :proceso";
	}
	
	$conexion = conectaBaseDatos();
	$sentencia = $conexion->prepare($consulta);
	$sentencia->bindParam('proceso',$estado);
	
	try {
		if(!$sentencia->execute()){
			print_r($sentencia->errorInfo());
		}
		$resultado = $sentencia->fetchAll();
		//$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		$sentencia->closeCursor();
	}
	catch(PDOException $e){
		echo "Error al ejecutar la sentencia: \n";
			print_r($e->getMessage());
	}
	
	return $resultado;
}




?>
