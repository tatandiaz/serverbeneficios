<?php
 header('Content-Type: text/html; charset=UTF-8');
class Config {
	// Config Sitio
	const NOMBRE_SITIO = "Mqa App Server";
	const CHARSET = "text/html; charset=ISO-8859-1";
	const CLASE_CUERPO = "";
	const PAGINA_LOGIN = "Login.phtml";
	const PAGINA_PIE = "Pie.phtml";
	const PAGINA_WORKSPACE = "Workspace.phtml";
	const PAGINA_ERROR = "ErroresWeb.phtml";
	const DOMINIO_AUTORIZADO = "";
	const VALIDAR_DOMINIO = false;
	
	// Config Home
	const PAGINA_WORKSPACE_HOME = "Workspacehome.phtml";
	const PAGINA_PIE_HOME = "Piehome.phtml";
	const PAGINA_CARACTERES_DESC = 100;
	
	// Config Mail
	const MAIL_SMTPAUTHE	= true;								// enable SMTP authentication
	const MAIL_PORT			= 25;								// set the SMTP server port
	const MAIL_HOST			= "smtp.inversusa.com";				// SMTP server
	const MAIL_USERNAME		= "";		// SMTP server username
	const MAIL_PASSWORD		= "";							// SMTP server password
	const MAIL_SMTPSECURE	= "";								// Secure method
	
	const MAIL_REMITENTE = "director@inversusa.com";
	const MAIL_LABEL_REMITENTE = "Komiyama Admin";
	const MAIL_SUBJECT = "";
	
	// Config admin
	const USU_ADM = "root";
	const PAS_ADM = "802c92bfd4ba6f827781806f6c882531";
	
	// Global Config
	const CARPETA_REPOSITORIOS = "repo";
	const NOMBRE_CAMPO_UPLOAD = "campo";
}
?>