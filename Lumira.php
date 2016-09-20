<!DOCTYPE HTML> 
<html>
<head>
<?php header('Content-Type: text/html; charset=UTF-8');?>
<title>Prueba Grafica</title>
 <link rel="stylesheet" type="text/css" href="Mycss.css"> 
 <?php require_once ("Conexion.php"); ?> 
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Responsables vs Proceso</title>
		<script type="text/javascript" src="Highcharts-4.2.5/api/js/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="jsSelectOption.js"></script> 
</head>
<body class="body">
<script src="Highcharts-4.2.5/js/highcharts.js"></script>
<script src="Highcharts-4.2.5/js/highcharts-3d.js"></script>
<script type="text/javascript" src="Highcharts-4.2.5/js/themes/MyTheme.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<div id="container" style="height: 350px"></div>
     <br/>
     <br/>
   <?php 
        $sql = 'SELECT * FROM responsables';
        $result = $mysqli->query($sql);     
   ?>
   <?php   while($res=mysqli_fetch_array($result)):?>
        <?php $datos = $res ['nombre'] ;?>
        <?php $lista = array ($datos);?>
        <?php $repetidos = array_unique($lista); 
 foreach ($repetidos as $value)
    {   
    echo $value . "<br>";
    }
    ?>
      <?php endwhile; ?>

      <div class="controlGrafica">
        <select id="select" name="nameMesa" class="select" required>
          <option value="">Selecciona la mesa</option>
          <option value="div1">Mesa1</option>
          <option value="div2">Mesa2</option>
          <option value="div3">Mesa3</option>
          <option value="div4">Mesa4</option>
          <option value="div5">Mesa5</option>
          <option value="div6">Mesa6</option>
          <option value="div7">Mesa7</option>
          <option value="div8">Mesa8</option> 
          <option value="div9">Mesa9</option>
          <option value="div10">Mesa10</option> 
        </select>
      </div>

<div id="opciones">
             <div id="div1" >
             Mesa 1          
             </div>

             <div id="div2">             
             Mesa 2
             </div>

             <div id="div3">
             Mesa 3
             </div>

             <div id="div4">
             Mesa 4
             </div>

             <div id="div5">
             Mesa 5
             </div>

             <div id="div6">
             Mesa 6
             </div>

             <div id="div7">
             Mesa 7
             </div>
                        
             <div id="div8">
             Mesa 8
             </div>

             <div id="div9">
             Mesa 9
             </div>
     
             <div id="div10">
             Mesa 10
             </div>
</div>

	</body>

     <script type="text/javascript" >
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'Responsables vs Procesos'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Es responsable de',
      
            data: [
                <?php 
        $sql = 'SELECT * FROM responsables';
        $result = $mysqli->query($sql);     
 ?>
       <?php   while($res=mysqli_fetch_array($result)):?>
       <?php $valor = "4" ?>
                ['<?php echo $res['nombre'] ?>',   <?php echo $valor ?> ],
                 <?php endwhile; ?>
       
            ]
        }]
    });
});
		
</script>
</html>

