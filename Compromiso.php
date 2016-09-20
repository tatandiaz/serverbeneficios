<?php header('Content-Type: text/html; charset=UTF-8');?>
<link rel="shortcut icon" href="temas/img/mqa.png">
<TITLE>Compromiso</TITLE>
<link rel="stylesheet" type="text/css" href="Mycss.css"> 

<body class="body">

  <a href="./" class="btnReturn">AREA DE TRABAJO</a> 

<form action="Compromiso.php"  method="POST" >
 <strong class="TitleCompromiso" >COMPROMISO</strong>
  <fieldset class="styleFromCompromiso">
  <legend ></legend>
 
    <br/>
    <textarea placeholder="Escribe tu compromiso " class="labelComp" name="nameCompromiso" rows="5" cols="50"></textarea>
    <br/><br/>
    <input type="text" class="labelPlaceholder" name="nameResponsable" placeholder="Responsable"/>
    <br/><br/>
    <input type="text"  class="labelPlaceholder" name="nameCargo" placeholder="Cargo"/>
    <br/><br/>
    <input type="date"  class="labelFecha" name="nameFecha"/>
    <br/>
    <input class="btnGuardarCompromiso" type="submit" name="btnCompromisos" value="GUARDAR"/>
 <input class="btnVerCompromisos" type="button" id="btnMostrar"  onclick="mostrarTabla()"  value="VER REGISTROS"></input>
  
</fieldset>

</form>

    <?php

if ( isset( $_POST['btnCompromisos'] )  ) {
  
  // Connect to MySQL
  $mysqli = new mysqli( 'localhost', 'root', 'juan', 'mqabeneficios' );
  
  // Check our connection
  if ( $mysqli->connect_error ) {
    die( 'Connect Error: ' . $mysqli->connect_errno . ': ' . $mysqli->connect_error );
  }

 // Insert our data
  $sql = "INSERT INTO compromiso ( compromiso, responsable, cargo, fecha ) VALUES ( '{$mysqli->real_escape_string($_POST['nameCompromiso'])}', '{$mysqli->real_escape_string($_POST['nameResponsable'])}', '{$mysqli->real_escape_string($_POST['nameCargo'])}','{$mysqli->real_escape_string($_POST['nameFecha'])}')";
  $insert = $mysqli->query($sql);
  
  // Print response from MySQL
  if ( $insert ) {
    echo '<script language="javascript">alert("COMPROMISO GUARDADO");</script>'; 
  } else {
    die("Error: {$mysqli->errno} : {$mysqli->error}");
  }
  }

?>
<?php 
  // Connect to MySQL
  $mysqli = new mysqli( 'localhost', 'root', 'juan', 'mqabeneficios' );
  
  // Check our connection
  if ( $mysqli->connect_error ) {
    die( 'Connect Error: ' . $mysqli->connect_errno . ': ' . $mysqli->connect_error );
  }

  
?> 

<form id='tablaOculta' action="delComp.php" style='display:none;' method="POST">
<a href="/ServerBeneficios/CompromisoPDF.php"><img src="temas/img/pdf.png" class="btnPDFcompromiso" ></a>

<div id="div1">
    <table border="1" class="tablaCompromisos" >
      <tr class="encabezados">
        <th class="celdaComp">COMPROMISO</th>
        <th class="celdaResponsable">RESPONSABLE</th>
        <th>CARGO</th>
        <th class="celdaFechaCom">FECHA</th>
        <th class="modificar"></th>
        <th class="CeldaEliminar"><input class="StyleBotonEliminar" type="submit" name="btnEliminar" value="X"/></th>

      </tr>
      
      <?php

  // Connect to MySQL
  $mysqli = new mysqli( 'localhost', 'root', 'juan', 'mqabeneficios' );
  
  // Check our connection
  if ( $mysqli->connect_error ) {
    die( 'Connect Error: ' . $mysqli->connect_errno . ': ' . $mysqli->connect_error );
  }

$sql = "SELECT * FROM compromiso";
$result = $mysqli->query($sql);
    ?>
<?php while($columna = mysqli_fetch_array($result)):?>
      <tr>
        <td>
          <?php echo $columna['compromiso'] ?>
        </td>
        <td>
          <?php echo $columna['responsable'] ?>
        </td>
        <td>
          <?php echo $columna['cargo'] ?>
        </td>
        <td>
          <?php echo $columna['fecha'] ?>
        </td>
       <td class="modificar"><a  class="ContUpdate"  href="UpdateCompromiso.php?id=<?php echo $columna['id'];?>"><img type=button href="UpdateCompromiso.php" class="btnEdit" name="btnEdit"  src="temas/img/edit.png"></a></td>
     

   
        <td class="CeldaEliminar"><input  type="checkbox" name="capturaids[]" value=" <?php echo $columna['id']; ?> "></td>

  
       
      </tr>


      <?php endwhile; ?>


    </table>
      </div>   
</form>




<script type="text/javascript">
  function mostrarTabla(){
  document.getElementById('tablaOculta').style.display ='block';}
</script>

</body>
<footer class="fotterMQA">
   <img src="temas/img/mqa.png" width="100" height="55" />
   <div>&#174; Marca Registrada</div>  
 </footer>
 
