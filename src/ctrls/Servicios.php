<?php
 header('Content-Type: text/html; charset=UTF-8');
class Servicios{
	
	public static function ListaTaller(){
	
		$talleres = new Talleres();
		$ver = "*";
		$extra = "where id > 0";
		$lista = $talleres->readInfo($ver, $extra);
	
		$arrJson = array();
		foreach ($lista as $id => $vl){
			$arrJson[] = Utiles::objToArray($vl);
		}
	
		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST');
		return json_encode($arrJson, JSON_HEX_AMP);
	}
	
	public static function ListaMesas(){
		
		if( isset( $_POST["idtaller"] ) ){
				
			$idtaller = $_POST["idtaller"];
			
			$ver = "*";
			$extra = "where talleres_id = " . $idtaller;
		
			$mesas = new Mesas();
			$lista = $mesas->readInfo($ver, $extra);
			
			$arrJson = array();
			foreach ($lista as $id => $vl){
				$arrJson[] = Utiles::objToArray($vl);				
			}
			
			header('Content-Type: application/json');
			header('Access-Control-Allow-Origin: *');
			header('Access-Control-Allow-Methods: GET, POST');
			return json_encode($arrJson, JSON_HEX_AMP);
		}
	}
	
	private static function crearCateArray($dbArr){
		/* 1	principal
		 * 2	sugerencia
		 * 3	admin
		*/
		$ordenCats = array();
		foreach ($dbArr as $key => $value) {
			if( $value->getTiposcategoria_id() == 1 || $value->getTiposcategoria_id() == 3 ){
				$ordenCats[ $value->getTiposcategoria_id() ][ $value->getId() ] = Utiles::objToArray( $value, true );
			}
		}
		
		foreach ($dbArr as $key => $value) {
			if ( $value->getTiposcategoria_id() == 2 ) {
				$ordenCats[ 1 ][ $value->getDependencia() ]["hijos"][] = Utiles::objToArray( $value , true );
			}
		}

		return $ordenCats;
	} 
	
	public static function ListaProcesos(){
		
		if( isset( $_POST["idmesas"] ) ){
			
			$idMesa = $_POST["idmesas"];
			$idtaller = $_POST["idtaller"];
			
			$procesos = new Procesos();
			$ver = "*";
			$extra = "where mesas_id = " . $idMesa . " and talleres_id = " . $idtaller . " and categorias_id = 0";
			$lista = $procesos->readInfo($ver, $extra);	
			$arrJson = array();
			$objJson1 = array();
			foreach ($lista as $id => $vl){
				$objJson1[] = Utiles::objToArray($vl, true);
			}
			
			$arrJson["proce"] = $objJson1;
			
			$categ = new Categorias();
			$verCat = "*";
			$extraCat = "where talleres_id = " . $idtaller;
			$cats = $categ->readInfo($verCat, $extraCat);
			
			$arrJson["cats"] = self::crearCateArray($cats);
			
			header('Content-Type: application/json');
			header('Access-Control-Allow-Origin: *');
			header('Access-Control-Allow-Methods: GET, POST');
			return json_encode($arrJson, JSON_HEX_AMP);
			}
   	}

        public static function ExportarDatosIndicadores(){
        header('Content-Type: text/html; charset=UTF-8');

        $conexion = new mysqli('127.0.0.1','root','juan','mqabeneficios');

        $consulta = "SELECT procesos.proceso,mesas.nombre FROM procesos INNER JOIN 
                     mesas ON mesas.id=procesos.mesas_id ORDER BY procesos.proceso ASC";
        $consulta_mesas ="SELECT mesas.nombre,procesos.proceso FROM procesos INNER JOIN 
                          mesas ON mesas.id=procesos.mesas_id ORDER BY procesos.proceso ASC";
        $consulta_categorias ="SELECT categorias.nombre,procesos.proceso FROM procesos INNER JOIN
                               categorias ON categorias.id=procesos.categorias_id ORDER BY procesos.proceso ASC";
        $consulta_CatCliente = "SELECT categoriacliente.nombre,categoriacliente.proceso FROM 
                                categoriacliente ORDER BY categoriacliente.proceso ASC ";       
        $consulta_CatEstrategia = "SELECT categoriaestrategia.nombre,categoriaestrategia.proceso FROM 
                                   categoriaestrategia ORDER BY categoriaestrategia.proceso ASC ";
        $consulta_responsable ="SELECT responsables.nombre,responsables.proceso FROM responsables 
                                ORDER BY responsables.proceso ASC";
        $consulta_fecha="SELECT procesos.fecha,procesos.proceso FROM procesos ORDER BY procesos.proceso ";

        
        $resultado = $conexion -> query ($consulta);
        $resultado_mesas = $conexion -> query ($consulta_mesas);
        $resultado_categorias = $conexion -> query ($consulta_categorias);
        $resultado_CatEstrategia= $conexion -> query ($consulta_CatEstrategia);
        $resultado_CatCliente= $conexion -> query ($consulta_CatCliente);
        $resultado_responsable = $conexion -> query ($consulta_responsable);
        $resultado_fecha=$conexion -> query ($consulta_fecha);

        require_once 'Classes/PHPExcel.php';

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setCreator("Name_Author") // Nombre del autor
        ->setLastModifiedBy("Name_Modification") //Ultimo usuario que lo modificó
        ->setTitle("Indicadores_Excel_con_PHPExcel") // Titulo
        ->setSubject("Indicadores_Excel") //Asunto
        ->setDescription("Indicadores_Excel") //Descripción
        ->setKeywords("Indicadores_Excel") //Etiquetas
        ->setCategory("Indicadores_Excel"); //Categorias
         
        // agregamos información a las celdas
        $tituloReporte = "INDICADORES";
        $titulosColumnas = array('Mesa','Proceso','Clasificacion','Categoria Cliente','Categoria Estrategica','Responsable','Fecha');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1',  $tituloReporte) 
        ->setCellValue('A2',  $titulosColumnas[0])  
        ->setCellValue('B2',  $titulosColumnas[1])
        ->setCellValue('C2',  $titulosColumnas[2])
        ->setCellValue('D2',  $titulosColumnas[3])
        ->setCellValue('E2',  $titulosColumnas[4])
        ->setCellValue('F2',  $titulosColumnas[5])
        ->setCellValue('G2',  $titulosColumnas[6])
        ;   

 $i = 3; 
        while ($fila = $resultado_mesas->fetch_array()) {
        $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('A'.$i, $fila[0]);
        $i++  ;
}
 $i = 3;
        while ($fila = $resultado->fetch_array()) {
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$i, $fila[0]);
        $i++  ;
}
 $i = 3; 
        while ($fila = $resultado_categorias->fetch_array()) {
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('C'.$i, $fila[0]);
        $i++  ;
}   
 $i = 3;
        while ($fila = $resultado_CatCliente->fetch_array()) {
        $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('D'.$i, $fila[0]);
        $i++  ;
} 
$i = 3;
        while ($fila = $resultado_CatEstrategia->fetch_array()) {
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('E'.$i, $fila[0]);
        $i++  ;
}
$i = 3;
        while ($fila = $resultado_responsable->fetch_array()) {
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('F'.$i, $fila[0]);
        $i++  ;
}
$i = 3;
        while ($fila = $resultado_fecha->fetch_array()) {
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('G'.$i, $fila[0]);
        $i++  ;
}

    //FILTRO
$objPHPExcel->getActiveSheet()->setAutoFilter("A2:B2"); 

 $estiloTituloReporte = array(
    'font' => array(
        'name'      => 'Verdana',
        'bold'      => true,
        'italic'    => false,
        'strike'    => false,
        'size' =>16,
        'color'     => array(
            'rgb' => '000000'
        )
    ),
    'fill' => array(
      'type'  => PHPExcel_Style_Fill::FILL_SOLID,
      'color' => array(
            'argb' => 'E5E7E9')
  ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_NONE
)    
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'rotation' => 0,
        'wrap' => TRUE
    ) 
);
$estiloTituloColumnas = array(
    'font' => array(
        'name'  => 'Arial',
        'bold'  => true,
        'color' => array(
            'rgb' => '000000'
        )
    ),
    'fill' => array(
        'type'       => PHPExcel_Style_Fill::FILL_SOLID,
  'rotation'   => 90,
        'startcolor' => array(
            'rgb' => 'E5E7E9'
        )
       
    ), 
        'alignment' =>  array(
        'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'wrap'      => true
    ),
    'borders' => array(
        'left' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN ,
      'color' => array(
              'rgb' => 'FFFFFF'
            )
        )
        )
);
$estiloInformacion = new PHPExcel_Style();
$estiloInformacion->applyFromArray( array(
    'font' => array(
        'name'  => 'Arial',
        'color' => array(
            'rgb' => '000000'        )
   ),

     'alignment' =>  array(
       
        'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'wrap'      => false
    ),
    'fill' => array(
  'type'  => PHPExcel_Style_Fill::FILL_SOLID,
  'color' => array(
            'argb' => 'DADADE')
  ),
    'borders' => array(
        'left' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN ,
      'color' => array(
              'rgb' => '#000000'
            )
        )
    )
));

$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($estiloTituloReporte);
$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($estiloTituloColumnas);
//$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A3:G".($i-1));

for($i = 'A'; $i <= 'B'; $i++){
    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
}
for($i = 'B'; $i <= 'C'; $i++){
    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
}
for($i = 'C'; $i <= 'D'; $i++){
    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
}
for($i = 'D'; $i <= 'E'; $i++){
    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
}
for($i = 'E'; $i <= 'F'; $i++){
    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
}
for($i = 'F'; $i <= 'G'; $i++){
    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
}
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Indicadores.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;

       
        }


   public static function ExportarDatosEntrevista(){
   
     $conexion = new mysqli('127.0.0.1','root','juan','mqabeneficios');
  
   //Consulta de datos para obtener datos del reporte

    $consulta = "SELECT entrevistas.entrevista,entrevistas.mesa,entrevistas.entrevistado,entrevistas.entrevistador,entrevistas.fecha FROM entrevistas  ORDER BY entrevistas.entrevista ASC";
    $resultado = $conexion -> query ($consulta);
    
    require_once 'Classes/PHPExcel.php';

    $objPHPExcel = new PHPExcel();

    $objPHPExcel->getProperties()->setCreator("Name_Author") // Nombre del autor
    ->setLastModifiedBy("Name_Modification") //Ultimo usuario que lo modificó
    ->setTitle("Entrevistas_Excel_con_PHPExcel") // Titulo
    ->setSubject("Entrevistas_Excel") //Asunto
    ->setDescription("Entrevistas_Excel") //Descripción
    ->setKeywords("Entrevistas_Excel") //Etiquetas
    ->setCategory("Entrevistas_Excel"); //Categorias
         
        // agregamos información a las celdas
    $tituloReporte = "ENTREVISTAS";
    $titulosColumnas = array('Entrevista','Mesa','Entrevistado','Entrevistador','Fecha');
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1');
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1',  $tituloReporte) 
    ->setCellValue('A2',  $titulosColumnas[0])  
    ->setCellValue('B2',  $titulosColumnas[1])
    ->setCellValue('C2',  $titulosColumnas[2])
    ->setCellValue('D2',  $titulosColumnas[3])
    ->setCellValue('E2',  $titulosColumnas[4])
    
    ;
   

   $i = 3; 
        while ($fila = $resultado->fetch_array()) {
         $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('A'.$i, $fila[0])
         ->setCellValue('B'.$i, $fila[1])
         ->setCellValue('C'.$i, $fila[2])
         ->setCellValue('D'.$i, $fila[3])
         ->setCellValue('E'.$i, $fila[4])
         ;
         $i++;
}
 
$objPHPExcel->getActiveSheet()->setAutoFilter("B2:C2"); 

 $estiloTituloReporte = array(
    'font' => array(
        'name'      => 'Verdana',
        'bold'      => true,
        'italic'    => false,
        'strike'    => false,
        'size' =>16,
        'color'     => array(
            'rgb' => 'FFFFFF'
        )
    ),
    'fill' => array(
      'type'  => PHPExcel_Style_Fill::FILL_SOLID,
      'color' => array(
            'argb' => '848484')
  ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_NONE
)    
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'rotation' => 0,
        'wrap' => TRUE
    ) 
);
$estiloTituloColumnas = array(
    'font' => array(
        'name'  => 'Arial',
        'bold'  => true,
        'color' => array(
            'rgb' => 'FFFFFF'
        )
    ),
    'fill' => array(
        'type'       => PHPExcel_Style_Fill::FILL_SOLID,
  'rotation'   => 90,
        'startcolor' => array(
            'rgb' => '848484'
        )
       
    ), 
        'alignment' =>  array(
        'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'wrap'      => true
    ),
    'borders' => array(
        'left' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN ,
      'color' => array(
              'rgb' => 'FFFFFF'
            )
        )
        )
);
$estiloInformacion = new PHPExcel_Style();
$estiloInformacion->applyFromArray( array(
    'font' => array(
        'name'  => 'Arial',
        'color' => array(
            'rgb' => '000000'        )
   ),

     'alignment' =>  array(
       
        'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'wrap'      => false
    ),
    'fill' => array(
  'type'  => PHPExcel_Style_Fill::FILL_SOLID,
  'color' => array(
            'argb' => 'DADADE')
  ),
    'borders' => array(
        'left' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN ,
      'color' => array(
              'rgb' => '#000000'
            )
        )
    )
));

$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($estiloTituloReporte);
$objPHPExcel->getActiveSheet()->getStyle('A2:E2')->applyFromArray($estiloTituloColumnas);
//$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A3:E".($i-1));

for($i = 'A'; $i <= 'B'; $i++){
    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
}
for($i = 'B'; $i <= 'C'; $i++){
    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
}
for($i = 'C'; $i <= 'D'; $i++){
    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
}
for($i = 'D'; $i <= 'E'; $i++){
    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
}


        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Entrevistas.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;

    }


    	public static function ExportarDatos(){
   $temp=0;
   $conexion = new mysqli('127.0.0.1','root','juan','mqabeneficios');
 
    $consulta = "SELECT procesos.proceso,procesos.id FROM procesos INNER JOIN mesas ON mesas.id=procesos.mesas_id";
       $consulta_responsable ="SELECT nombre FROM responsables";
  

    $resultado = $conexion -> query ($consulta);
    $resultado_responsable = $conexion -> query ($consulta_responsable);
    
    require_once 'Classes/PHPExcel.php';

    $objPHPExcel = new PHPExcel();

    $objPHPExcel->getProperties()->setCreator("Name_Author") // Nombre del autor
    ->setLastModifiedBy("Name_Modification") //Ultimo usuario que lo modificó
    ->setTitle("Reporte_Excel_con_PHPExcel") // Titulo
    ->setSubject("Reporte_Excel") //Asunto
    ->setDescription("Reporte_Excel") //Descripción
    ->setKeywords("Reporte_Excel") //Etiquetas
    ->setCategory("Reporte_Excel"); //Categorias
         
    // agregamos información a las celdas
    $tituloReporte = "RESULTADO TALLER DE PROCESOS";
    $titulosColumnas = array('Procesos', 'Mesa', 'Clasificacion', 'Punto de Dolor','Beneficios','Reto');
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:F1');
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1',  $tituloReporte) 
    ->setCellValue('A2',  $titulosColumnas[0])  
    ->setCellValue('B2',  $titulosColumnas[1])
    ->setCellValue('C2',  $titulosColumnas[2])
    ->setCellValue('D2',  $titulosColumnas[3])
    ->setCellValue('E2',  $titulosColumnas[4])
    ->setCellValue('F2',  $titulosColumnas[5])

    ;

        
   $i = 3;

//Inicia iteracion para sacar los valores de la tabla de procesos.
while ($fila = $resultado->fetch_array()) {
            $objPHPExcel->setActiveSheetIndex(0)
          //Asigna el nombre del proceso a la celda A.
            ->setCellValue('A'.$i, $fila[0]); 
             //Consulta la mesa a la cual pertenece el proceso.
    $consulta_mesas ="SELECT mesas.nombre,mesas.id FROM mesas INNER JOIN procesos  ON mesas.id=procesos.mesas_id where procesos.id='".$fila[1]."' ";
        $resultado_mesas = $conexion -> query ($consulta_mesas);
    $consulta_categorias="SELECT categorias.nombre FROM categorias INNER JOIN procesos  ON categorias.id=procesos.categorias_id where procesos.id='".$fila[1]."' ";
    $resultado_categorias = $conexion -> query ($consulta_categorias);
    $consulta_procesos_sugerencias_Puntos =  "SELECT SUBSTRING_INDEX(REPLACE(sugerencia,'PUNTOS DE DOLOR:  ',''), 'BENEFICIOS:',1) from procesos where procesos.id='".$fila[1]."' ";
    $resultado_procesos_sugerencias_puntos = $conexion -> query ($consulta_procesos_sugerencias_Puntos);
    $consulta_procesos_sugerencias_Beneficios =  "SELECT SUBSTRING_INDEX(sugerencia, ':', -1) from procesos where procesos.id='".$fila[1]."' ";
    $resultado_procesos_sugerencias_beneficios = $conexion -> query ($consulta_procesos_sugerencias_Beneficios);

while ($fila2 = $resultado_mesas->fetch_array()) {         
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$i, $fila2[0]);
$consulta_reto="SELECT reto.reto from reto inner join mesas ON mesas.id=reto.id_mesa  
 where mesas.id='".$fila2[1]."' " ;
         //Consulta el reto de la mesa 
    $resultado_reto= $conexion -> query ($consulta_reto);
 while ($fila = $resultado_categorias->fetch_array()) {         
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C'.$i, $fila[0]);
 while ($fila = $resultado_procesos_sugerencias_puntos->fetch_array()) {
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('D'.$i,  $fila[0]);
 while ($fila = $resultado_procesos_sugerencias_beneficios->fetch_array()) {
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E'.$i,  $fila[0]);

while ($fila = $resultado_reto->fetch_array()) {
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('F'.$i, $fila[0]);
           
            }

}
}
}
} 
$i++;

   }   
  
     
      
$objPHPExcel->getActiveSheet()->setAutoFilter("B2:C2"); 

 $estiloTituloReporte = array(
    'font' => array(
        'name'      => 'Arial',
        'bold'      => true,
        'italic'    => false,
        'strike'    => false,
        'size' =>16,
        'color'     => array(
            'rgb' => 'FFFFFF'
        )
    ),
    'fill' => array(
      'type'  => PHPExcel_Style_Fill::FILL_SOLID,
      'color' => array(
            'argb' => '1c3044')
  ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_NONE
)    
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'rotation' => 0,
        'wrap' => TRUE
    ) 
);
$estiloTituloColumnas = array(
    'font' => array(
        'name'  => 'Arial',
        'bold'  => true,
        'color' => array(
            'rgb' => 'FFFFFF'
        )
    ),
    'fill' => array(
        'type'       => PHPExcel_Style_Fill::FILL_SOLID,
  'rotation'   => 90,
        'startcolor' => array(
            'rgb' => '1c3044'
        )
       
    ), 
        'alignment' =>  array(
        'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'wrap'      => true
    ),
    'borders' => array(
        'left' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN ,
      'color' => array(
              'rgb' => '#000000'
            )
        )
        )
);
$estiloInformacion = new PHPExcel_Style();
$estiloInformacion->applyFromArray( array(
    'font' => array(
        'name'  => 'Arial',
        'color' => array(
            'rgb' => '000000'        )
   ),

     'alignment' =>  array(
       
        'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'wrap'      => false
    ),
    'fill' => array(
  'type'  => PHPExcel_Style_Fill::FILL_SOLID,
  'color' => array(
            'argb' => 'F2F4F4')
  ),
    'borders' => array(
        'left' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN ,
      'color' => array(
              'rgb' => '#000000'
            )
        )
    )
));

$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($estiloTituloReporte);
$objPHPExcel->getActiveSheet()->getStyle('A2:F2')->applyFromArray($estiloTituloColumnas);
//$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A3:E10".($i-1));
   
for($i = 'A'; $i <= 'B'; $i++){
    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
}
for($i = 'C'; $i <= 'D'; $i++){
    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
}
for($i = 'D'; $i <= 'E'; $i++){
    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
}
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
	}	

	public static function Guardar(){
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST');
		date_default_timezone_set('America/Bogota');
		
		if( !isset( $_POST["datos"] ) ){
			return "Se envio el tablero sin informacion. No se salvaron datos.";
		}
		$d = $_POST["datos"];
		$idMesa = $_POST["lamesa"];
		$idTaller = $_POST["eltaller"];	
            $retodesc=$_POST["elreto"];
		$cat = 0;
		$proceso = new Procesos();
		$salva = false;
		
		// Borramos toda la información anteriormente guardada
		//$pro = $proceso->readInfo("*", "where mesas_id = " . $idMesa . " and talleres_id = " . $idTaller);
		//foreach ($pro as $key => $value) {
		///	$value->setCategorias_id(0);
			//$value->setSugerencia("");
			//$value->updateData();
		//}
		
		foreach ($d as $key => $value) {
			
			$tmpO = explode("_", $key);
			$cat = $tmpO[1];
			
            foreach ($value as $idPro => $vlPro){				
				$tmpP = explode("_", $vlPro["idpro"]);
				$com = $vlPro["comentario"];
				$mesa = $vlPro["idmesa"];
				
				if( $tmpP[0] == "pro" ){
					$proceso->setId($tmpP[1]);
					$act = $proceso->readInfoById();
					$act->setSugerencia($com);
					$act->setCategorias_id( $cat );
					$op = $act->updateData();
					if( $op > 0 ){
						$salva = true;
					}
				}else if( $tmpP[0] == "esp"){
					$nwPro = new Procesos();
					$txtPro = "Proceso Nuevo";
					$sug = trim($com);
					$idCat = 1;
					$idt = $vlPro["idtaller"];
					$ver = "*";
					$extra = "where proceso like '" . $txtPro . "' and sugerencia like '" . $sug . "' and mesas_id = " . $mesa . " and categorias_id = " . $idCat . " and talleres_id = " . $idt;
					$existe = $nwPro->readInfo($ver, $extra);
					
					if(sizeof($existe) < 1){
						if( strlen( trim( $sug ) ) > 0 ){
							$nwPro->setProceso($txtPro);
							$nwPro->setSugerencia($sug);
							$nwPro->setFecha(date("Y-m-d h:i:s"));
							$nwPro->setMesas_id($mesa);
							$nwPro->setCategorias_id($idCat);
							$nwPro->setTalleres_id($vlPro["idtaller"]);
							$id = $nwPro->saveData();
							
							if ($id > 0) {
								$salva = true;
							}
						}
					}
				}
			}
		}
		
		if( $salva ){
            self::GuardarReto($retodesc,$idMesa);
			return "Informacion Guardada.";
		}
		else{
			return "No se guardaron datos.";
		}
	}
public  static function GuardarReto($descripcionreto,$mesa){
        
        $reto = new Reto();
        $salva = false;
        
        // Borramos toda la información anteriormente guardada en la tabla de reto
       
        $pro = $reto->readInfo("*", "where id_mesa = " .$mesa);
        if (empty($pro)){

          $newreto=new Reto();
          $newreto->setId_mesa($mesa);
          $newreto->setReto($descripcionreto);
          $idre=$newreto->saveData();

        }else{

foreach ($pro as $key => $value) {
            $value->setReto($descripcionreto);
            $value->updateData();
        }
        
        }
        
}

	
	public static function GuardarPlanning(){		
		$resErr = array();
		unset( $_POST["cmd"] );
		if(isset($_POST)){
			$datos = $_POST;
			$limpiar = true;
			
			foreach ($datos as $id => $vl){
				if(strlen(trim($vl)) > 0){
					$partes = explode("_",$id);
					
					if(sizeof($partes) > 1){
						$el = $partes[0];
						$tema = $partes[1];
						$ctrl1 = $partes[2];
							
						if( $el == "resesp"){
							$resultados = new Plann_resultados();
							$resultados->setPlann_temas_id($tema);
							$resultados->setValor($vl);
							
							if($limpiar){
								$resultados->deleteByField("plann_temas_id", $tema);
								$planacc = new Plann_accion();
								$planacc->deleteByField("plann_temas_id", $tema);
								
								$delres = $resultados->readInfo("*","where plann_temas_id = " . $tema);
								
								$limpiar = false;
							}
							
							$idR = $resultados->saveData();
							if( $idR < 1){
								$resErr[$id] = $idR;
							}
						}
						if( $el == "planacc" ){
							$catId = $_POST["cat_" . $tema . "_" . $ctrl1];
							$parId = $_POST["resp_" . $tema . "_" . $ctrl1];
							$fecha = $_POST["fecha_" . $tema . "_" . $ctrl1];
							$planacc = new Plann_accion();
							$planacc->setValor($vl);
							$planacc->setPlann_temas_id($tema);
							$planacc->setPlann_cat_id($catId);
							$planacc->setPlann_participante_id($parId);
							$planacc->setFecha($fecha);
							$idR = $planacc->saveData();
							if( $idR < 1){
								$resErr[$id] = $idR;
							}
						}
					}
				}
				else{
					$resErr[$id] = "No tiene datos.";
				}
			}
		
			if( sizeof($resErr) > 0 ){
				echo "Error salvando: \n";
				$txtRes = "";
				foreach ($resErr as $idE => $vlE){
					$txtRes .= $idE . ": " . $vlE . "\n";
				}
				echo $txtRes;
			}
			else{
				echo "Salvado correctamente!";
			}
			
		}
	}
	
	// Listar estructura
	public static function ListaEstructura(){
		
		if( isset( $_POST["idmesas"] ) ){
			
			$idMesa = $_POST["idmesas"];
			$idtaller = $_POST["idtaller"];
			
			$arrJson = array();
			$temas = new Plann_temas();
			$tArr = $temas->readInfo("*", "where talleres_id = " . $idtaller . " and mesas_id = " . $idMesa);
			foreach ($tArr as $id => $vl){
				$resesperado = array();
				for ($i = 0; $i < $vl->getPlanaccion(); $i++){
					$resesperado[] = $i;
				}
				$planaccion = array();
				for ($i = 0; $i < $vl->getResesperado(); $i++){
					$planaccion[] = $i;
				}
				
				$arrTmp1 = array();
				$arrTmp1["nombre"] = mb_convert_encoding($vl->getNombre(), "UTF-8", "ISO-8859-1");
				$arrTmp1["color"] = $vl->getColor();
				$arrTmp1["planaccion"] = $planaccion;
				$arrTmp1["resesperado"] = $resesperado;
				$arrJson[$vl->getId()] = $arrTmp1;
			}
			
			$cats    = new Plann_cat();
			$catRes  = $cats->readInfo("*", "where talleres_id = " . $idtaller);
			$arrCats = array();
			foreach ($catRes as $id => $vl){
				$arrCats[ $vl->getId() ] = mb_convert_encoding($vl->getNombre(), "UTF-8", "ISO-8859-1");
			}
			$part = new Plann_participante();
			$parRes = $part->readInfo("*", "where talleres_id = " . $idtaller);
			$arrResp = array();
			foreach ($parRes as $id => $vl){
				$arrResp[ $vl->getId() ] = mb_convert_encoding($vl->getNombre(), "UTF-8", "ISO-8859-1");
			}
			
			$jsonData = array("data" => $arrJson, "cats" => $arrCats, "resp" => $arrResp );
			
			header('Content-Type: application/json');
			header('Access-Control-Allow-Origin: *');
			header('Access-Control-Allow-Methods: GET, POST');
			return json_encode($jsonData, JSON_HEX_AMP);
			}
	    } 
    }
?>