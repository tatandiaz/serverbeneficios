<?php header('Content-Type: text/html; charset=UTF-8');?>
<title>Entrevista</title>
<link rel="stylesheet" type="text/css" href="Mycss.css"> 
<body class="body">
 <a href="./" class="btnReturn">AREA DE TRABAJO</a> 
<form action="Entrevistas.php"  method="POST" >
<strong class="TitleCompromiso" >ENTREVISTAS</strong>
  <fieldset class="styleFromEntrevistas">
  <legend ></legend>
<?php
        $servidor = "localhost";
        $basedatos = "mqabeneficios";
        $usuario = "root";
        $contrasena = "juan";
        $mysqli = new mysqli($servidor,$usuario,$contrasena,$basedatos);
        if ($mysqli -> connect_errno) {
        die( "Fallo la conexión a MySQL: (" . $mysqli -> mysqli_connect_errno(). ") " . $mysqli -> mysqli_connect_error());
        }
        else{
        echo "";
        }   
        $consulta = 'SELECT id, nombre FROM mesas ORDER BY nombre ASC';
        $resultado=mysqli_query ($mysqli, $consulta); 
        ?>
        <td>
          <select name="nameMesa" class="selectEntrevistas" required>
          <option>Selecciona la mesa</option>
            <?php
            while ($fila=mysqli_fetch_row($resultado)){     
            echo "<option value='".$fila['1']."'>".$fila['1']."</option>";  
            }
            ?>  
      </select>    
        </td>
    <br/><br/>
    <input type="date"  class="labelFecha" name="nameFecha" required/>
    <br/><br/>
    <input type="text"  class="labelEntrevistas" name="nameEntrevistado" placeholder="Entrevitado" required/>
    <br/><br/>
    <input type="text"  class="labelEntrevistas" name="nameEntrevistador" placeholder="Entrevistador" required/>
    <br/><br/>
    <textarea class="labelEntrevista" name="nameEntrevista" rows="1" cols="5" placeholder="Ingresa la entrevista" required></textarea>
    <br/>
   
   <input class="btnGuardarEntrevista" type="submit" name="btnEntrevistas" value="GUARDAR" />
 <input class="btnVerEntrevista" type="button" id="btnMostrar"  onclick="mostrarTabla()"  value="VER REGISTROS"></input>
</fieldset>
</form>
<?php
if ( isset( $_POST['btnEntrevistas'] )  ) {
  // Connect to MySQL
  $mysqli = new mysqli( 'localhost', 'root', 'juan', 'mqabeneficios' );
  // Check our connection
  if ( $mysqli->connect_error ) {
    die( 'Connect Error: ' . $mysqli->connect_errno . ': ' . $mysqli->connect_error );
  }
 // Insert our data
  $sql = "INSERT INTO entrevistas ( entrevista, entrevistado, entrevistador, mesa, fecha ) VALUES ( '{$mysqli->real_escape_string($_POST['nameEntrevista'])}', '{$mysqli->real_escape_string($_POST['nameEntrevistado'])}', '{$mysqli->real_escape_string($_POST['nameEntrevistador'])}','{$mysqli->real_escape_string($_POST['nameMesa'])}','{$mysqli->real_escape_string($_POST['nameFecha'])}')";
  $insert = $mysqli->query($sql); 
  // Print response from MySQL
  if ( $insert ) {
    echo '<script language="javascript">alert("ENTREVISTA GUARDADA CORRECTAMENTE");</script>'; 
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
<form id='tablaOculta' action="delEntre.php" style='display:none;' method="POST">
<a href="/ServerBeneficios/EntrevistaPDF.php"><img  src="temas/img/pdf.png" class="btnPDFentrevistas"></a>
    <table border="1" class="tablaEntrevistas" >
      <tr class="encabezados">
        <th class="celdaEntrevista">Entrevista</th>
        <th>Mesa</th>        
        <th>Entrevistado</th>
        <th>Entrevistador</th>
        <th>Fecha</th>
      <th></th>
        <th class="CeldaEliminar"><input class="StyleBotonEliminar" type="submit" name="btnEliminar" value="X"/></th>
      </tr>
      <?php
  // Connect to MySQL
  $mysqli = new mysqli( 'localhost', 'root', 'juan', 'mqabeneficios' );
  // Check our connection
  if ( $mysqli->connect_error ) {
    die( 'Connect Error: ' . $mysqli->connect_errno . ': ' . $mysqli->connect_error );
  }
$sql = "SELECT * FROM entrevistas";
$result = $mysqli->query($sql);
    ?>
<?php while($columna = mysqli_fetch_array($result)):?>
      <tr>      
        <td>
          <?php echo $columna['entrevista'] ?>
        </td>
         <td>
          <?php echo $columna['mesa'] ?>
        </td>       
        <td>
          <?php echo $columna['entrevistado'] ?>
        </td>
        <td>
          <?php echo $columna['entrevistador'] ?>
        </td>
        <td>
          <?php echo $columna['fecha'] ?>
        </td>
       <td class="modificar"><a  class="ContUpdate"  href="UpdateEntrevista.php?id=<?php echo $columna['id'];?>"><img type=button href="UpdateEntrevista.php" class="btnEdit" name="btnEdit"  src="temas/img/edit.png"></a></td>
        <td class="CeldaEliminar"><input type="checkbox" name="capturaids[]" value=" <?php echo $columna['id'];?> "></td>
      </tr>
      <?php endwhile; ?>
    </table>
</form>
<script type="text/javascript">
  function mostrarTabla(){
  document.getElementById('tablaOculta').style.display ='block';}
</script>
<footer class="fotterMQA">
   <img src="temas/img/mqa.png" width="100" height="45" />
    <div>&#174; Marca Registrada</div>
  </footer>
</body>
