<?php
require('fpdf/fpdf.php');

class PDF extends FPDF{
}

//Declarar Hoja
$pdf=new PDF ('P','mm','Letter');

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Image('temas/img/mqa.png',2,2,50);

#Establecemos los márgenes izquierda, arriba y derecha: 
$pdf->SetMargins(35, 20, 35);
$pdf->SetAutoPageBreak(true, 20);


//Titulo
$pdf->SetTextColor(0x00,0x00,0x00);
$pdf->SetFont("Arial","b","9");
$pdf->Cell(0,5,'EntrevistaMQA',0,0,'C');
/*//Conexión
$mysqli = new mysqli( 'localhost', 'root', 'juan', 'mqaapps' );
  
// Check our connection
if ( $mysqli->connect_error ) {
    die( 'Connect Error: ' . $mysqli->connect_errno . ': ' . $mysqli->connect_error );
}*/
mysql_connect("localhost","root","juan");
mysql_select_db("mqaapps");
  //mostrar Tabla
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();




$sql="SELECT * FROM entrevistas";
$rec=mysql_query($sql);

while ($row=mysql_fetch_array($rec)){
$horaActual = date("H:m:s");
$pdf->Cell(0,10,'FECHA: '.$row['fecha'].'       HORA: '.$horaActual,1,1,'L');
//$pdf->Cell(0,6, 'HORA: '.$horaActual,1,1,'L');
$pdf->Ln();
$pdf->Cell(0,10,'MESA: '.$row['mesa'],1,1,'L');

$pdf->Cell(0,10,'ENTREVISTADO: '.$row['entrevistado'],1,1,'L');

$pdf->Cell(0,10,'ENTREVISTADOR: '.$row['entrevistador'],1,1,'L');
$pdf->Ln(); 
$pdf->Cell(0,10,'ENTREVISTA',0,1,'L');

$pdf->MultiCell(147,5,$row['entrevista'],1);

$pdf->addpage();
$pdf->Image('temas/img/mqa.png',5,5,50);
$pdf->Ln();
$pdf->Ln();

//Titulo
$pdf->SetTextColor(0x00,0x00,0x00);
$pdf->SetFont("Arial","b","9");
$pdf->Cell(0,5,'EnterevistaMQA',0,1,'C');
$pdf->Ln();
$pdf->Ln();






}

$pdf-> Output("ReporteEntrevista.pdf","D");
//$pdf-> Output("");
?>