<?php
/**
 * 
 * @author yalfonso
 *
 */
  header('Content-Type: text/html; charset=UTF-8');
class Correo {
	
	private $to = "";
	private $subject = "";
	private $message = "";
	
	private $isCal = false;
	private $start = "20000101T160000";
	private $end = "20010101T180000";
	private $summary = "Resumen";
	private $location = "Lugar";
	private $esHTML = false;
	
	public function setPara($vl){
		$this->to = $vl;
	}
	
	public function setTitulo($vl){
		$this->subject = $vl;
	}
	
	public function setMensaje($vl){
		$this->message = $vl;
	}
	
	public function setEsCalendario($vl){
		$this->isCal = $vl;
	}
	
	public function setFechaInicio($vl){
		$this->start = $vl;
	}
	
	public function setFechaFin($vl){
		$this->end = $vl;
	}
	
	public function setResumen($vl){
		$this->summary = $vl;
	}
	
	public function setLugar($vl){
		$this->location = $vl;
	}
	
	public function setEsHTML($vl){
		$this->esHTML = $vl;
	}
	
	public function dateToCal($timestamp) {
		return date('Ymd\THis\Z', $timestamp);
	}
	
	public function enviar()
	{
		include_once ( dirname(dirname( __FILE__ )) . DIRECTORY_SEPARATOR . "libs" . DIRECTORY_SEPARATOR . "PHPMailer-master" . DIRECTORY_SEPARATOR . "PHPMailerAutoload.php");
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth   = Config::MAIL_SMTPAUTHE;
		$mail->Port       = Config::MAIL_PORT;
		$mail->Host       = Config::MAIL_HOST;
		$mail->Username   = Config::MAIL_USERNAME;
		$mail->Password   = Config::MAIL_PASSWORD;
		$mail->SMTPSecure = Config::MAIL_SMTPSECURE;
	
		$mail->From       = Config::MAIL_REMITENTE;
		$mail->FromName   = Config::MAIL_LABEL_REMITENTE;
	
		$mail->IsHTML( $this->esHTML );
		$mail->ContentType = 'text/calendar';
	
		$mail->addCustomHeader('MIME-version',"1.0");
		$mail->addCustomHeader('Content-type',"text/calendar; method=REQUEST; charset=UTF-8");
		$mail->addCustomHeader('Content-Transfer-Encoding',"8bit");
		$mail->addCustomHeader("Content-class: urn:content-classes:calendarmessage");
	
		$mailerror="Mailer Error: " . $mail->ErrorInfo;
		$mailsuccess="Sent!";
		$body = preg_replace("[\\\\]",'',$this->message);
		$mail->AddAddress($this->to);
		$mail->Subject = $this->subject;
	
		if ( $this->isCal === true ){
	
			$event_id = date('Ymdhis');
			$sequence = 0;
			$status = 'CONFIRMED';
			
			$icalTxt  = "BEGIN:VCALENDAR\r\n";
			$icalTxt .= "PRODID:-//YourCassavaLtd//EateriesDept//EN\r\n";
			$icalTxt .= "VERSION:2.0\r\n";
			$icalTxt .= "METHOD:REQUEST\r\n";
			$icalTxt .= "BEGIN:VEVENT\r\n";
			$icalTxt .= "DTSTART:". $this->start . "\r\n";
			$icalTxt .= "DTEND:". $this->end . "\r\n";
			
			//$icalTxt .= "DTSTAMP:" . $this->dateToCal(time()) . "\r\n";
			$icalTxt .= "DTSTAMP:" . gmdate("Ymd\THis\Z", time()) . "\r\n";
			//$icalTxt .= "DTSTAMP;TZID=" . date_default_timezone_get() . ":" . date('Ymd').'T'.date('His')."\r\n";
			$icalTxt .= "ORGANIZER;SENT-BY=\"MAILTO:" . Config::MAIL_REMITENTE . "\":MAILTO:" . Config::MAIL_REMITENTE ."\r\n";
			$icalTxt .= "UID:".strtoupper(md5($event_id))."-yeicot.com\r\n";
			$icalTxt .= "ATTENDEE;CN=" . Config::MAIL_REMITENTE . ";ROLE=REQ-PARTICIPANT;PARTSTAT=ACCEPTED;RSVP=TRUE:" . Config::MAIL_REMITENTE . "\r\n";
			$icalTxt .= "SEQUENCE:".$sequence."\r\n";
			$icalTxt .= "STATUS:".$status."\r\n";
			$icalTxt .= "DESCRIPTION:". $this->summary ."\r\n";
			$icalTxt .= "LOCATION:". $this->location . "\r\n";
			$icalTxt .= "SUMMARY:". $this->subject ."\r\n";
			$icalTxt .= "BEGIN:VALARM\r\n";
			$icalTxt .= "TRIGGER:-PT15M\r\n";
			$icalTxt .= "ACTION:DISPLAY\r\n";
			$icalTxt .= "END:VALARM\r\n";
			$icalTxt .= "END:VEVENT\r\n";
			$icalTxt .= "END:VCALENDAR\r\n";
		
			$mail->Body = $icalTxt . $body;
	
			if(!$mail->Send()){
				return $mailerror;
			}else{
				return $mailsuccess;
			}
		}
		else
		{
			$mail->MsgHTML($body);
			if(!$mail->Send()){
				return $mailerror;
			}else{
				return $mailsuccess;
			}
		}
	}
	
}
?>