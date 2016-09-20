<?php

require('fpdf/fpdf.php');

class PDF extends FPDF{
}

//Declarar Hoja
$pdf=new PDF ('P','mm','Letter');
$pdf->SetMargins(35, 20, 35);

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Image('temas/img/mqa.png',5,5,50);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
//Titulo
$pdf->SetTextColor(0x00,0x00,0x00);
$pdf->SetFont("Arial","b","9");
$pdf->Cell(0,5,'COMPROMISO',0,1,'C');

mysql_connect("localhost","root","juan");
mysql_select_db("mqabeneficios");
  //mostrar Tabla
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();


$sql="SELECT * FROM compromiso";
$rec=mysql_query($sql);

while ($row=mysql_fetch_array($rec)){

$horaActual = date("H:m:s");
$pdf->Cell(0,10,'FECHA: '.$row['fecha'].'        HORA: '.$horaActual,1,1,'L');
$pdf->Cell(0,10,'RESPONSABLE: '.$row['responsable'],1,1,'L');
$pdf->Cell(0,10,'CARGO: '.$row['cargo'],1,1,'L');
//$pdf->Cell(0,6, 'HORA: '.$horaActual,0,1,'L');
$pdf->Ln();

$pdf->Cell(0,10,'YO ME COMPROMETO A: ',0,1,'L');

$pdf->MultiCell(147,5,$row['compromiso'],1);

$pdf->addpage();
$pdf->Image('temas/img/mqa.png',5,5,50);
$pdf->Ln();
$pdf->Ln();

//Titulo
$pdf->SetTextColor(0x00,0x00,0x00);
$pdf->SetFont("Arial","b","9");
$pdf->Cell(0,5,'COMPROMISO',0,1,'C');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

}

$pdf-> Output("Compromiso.pdf","D");
//$pdf-> Output("");
?>