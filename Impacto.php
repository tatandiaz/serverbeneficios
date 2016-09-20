<?php header('Content-Type: text/html; charset=UTF-8');?>
<TITLE>Impacto</TITLE>
<link rel="stylesheet" type="text/css" href="Mycss.css">
  <body class="body">
    <?php require_once("funciones.php");?>
    <script src="jquery-1.10.2.min.js"></script>
    <a href="./" class="btnReturn">AREA DE TRABAJO</a> 
    <form  action="Impacto.php" method="POST">
      <strong class="TitleImpacto" >IMPACTO</strong>
          <fieldset class="styleFromImpacto">
            <legend class="labelImpacto" ></legend>
            <div>
            <table width="503" border="0">
         
              </td>
            </tr>
            <tr>          
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
        <br/>
        <select name="mesa" id="mesa" class="CamposImpacto">
        <option value=""> Seleccione la mesa </option>
        <?php
		$estados = dameEstado();
		
		foreach($estados as $indice => $registro){
			echo "<option value='".$registro['id']."  ".$registro['nombre']."'>".$registro['nombre']."</option>";
		}
		?>
         </select>
            <br><br>
               <select name="proceso" id="proceso" class="CamposImpacto" >
                   <option value=""> Primero seleccione la mesa </option>
               </select>
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
        $consulta = 'SELECT id, impacto FROM creaimpacto ORDER BY impacto ASC';
        $resultado=mysqli_query ($mysqli, $consulta); 
        ?>
            <br/><br/>
                  
          <select name="CampNombres" class="CamposImpacto">
          <option>Seleccione nivel de impacto</option>"; 
            <?php
            while ($fila=mysqli_fetch_row($resultado)){     
            echo "<option value='".$fila['1']."'>".$fila['1']."</option>";  
            }
            ?>  
      </select> 
          </table>
              <input class="btnGuardarImpacto" type="submit" name="btnImpacto" value="GUARDAR"/>
              <input type="button" id="btnMostrar" class="btnVerImpacto" onclick="mostrartablaImpacto()"  value="VER REGISTROS"></input>
          </div>
     </fieldset>
    </form>
    <script>
      $("#mesa").on("change", buscarMunicipios);
      function buscarMunicipios(){
      $("#localidad").html("<option value=''>primero seleccione una mesa </option>");
      $estado = $("#mesa").val();
      if($estado == ""){
      $("#municipio").html("<option value=''> primero seleccione una mesa </option>");
      }
      else {
      $.ajax({
      dataType: "json",
      data: {"mesa": $estado},
      url:   'buscar.php',
      type:  'post',
      beforeSend: function(){
      //Lo que se hace antes de enviar el formulario
      },
      success: function(respuesta){
      //lo que se si el destino devuelve algo
      $("#proceso").html(respuesta.html);
      },
      error:	function(xhr,err){
      alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
      }
      });
      }
      }
      function buscarLocalidades(){
      $municipio = $("#proceso").val();
      $.ajax({
      dataType: "json",
      data: {"municipio": $municipio},
      url:   'buscar.php',
      type:  'post',
      beforeSend: function(){
      //Lo que se hace antes de enviar el formulario
      },
      success: function(respuesta){
      //lo que se si el destino devuelve algo
      $("#localidad").html(respuesta.html);
      },
      error:	function(xhr,err){
      alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
      }
      });
      }
    </script>
<?php
if ( isset( $_POST['btnImpacto'] )  ) {
  
  // Connect to MySQL
  $mysqli = new mysqli( 'localhost', 'root', 'juan', 'mqabeneficios' );
  
  // Check our connection
  if ( $mysqli->connect_error ) {
    die( 'Connect Error: ' . $mysqli->connect_errno . ': ' . $mysqli->connect_error );
  }
 // Insert our data
  $sql = "INSERT INTO impacto ( nombre, mesa, proceso ) VALUES ( '{$mysqli->real_escape_string($_POST['CampNombres'])}', '{$mysqli->real_escape_string($_POST['mesa'])}', '{$mysqli->real_escape_string($_POST['proceso'])}')";
  $insert = $mysqli->query($sql);
  // Print response from MySQL
  if ( $insert ) {
    echo '<script language="javascript">alert("NIVEL DE IMPACTO GUARDADO");</script>';
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
    <form  id='tablaOculta' action="DeleteImpacto.php" style='display:none;' method="POST">
      <table border="1" class="tabla" >
        <tr class="encabezados">
          <th>NIVEL DE IMPACTO</th>
          <th>MESA</th>
          <th>PROCESO</th>
          <th class="CeldaEliminar"><input class="StyleBotonEliminar" type="submit" name="btnEliminarImpacto" value="X"/></th>
        </tr>
<?php
$sql = "SELECT * FROM impacto";
$result = $mysqli->query($sql);
    ?>
        <?php while($columna = mysqli_fetch_array($result)):?>
        <tr>
          <td>
            <?php echo $columna['nombre'] ?>
          </td>
          <td>
            <?php echo $columna['mesa'] ?>
          </td>
          <td>
            <?php echo $columna['proceso'] ?>
          </td>
            <td class="CeldaEliminar"><input type="checkbox" name="capturaids[]" value=" <?php echo $columna['id'];?> "></td>
        </tr>
        <?php endwhile; ?>
      </table>
    </form>
<script type="text/javascript">
      function mostrartablaImpacto(){
      document.getElementById('tablaOculta').style.display ='block';}
</script>
<footer class="fotterMQA">
      <img src="temas/img/mqa.png" width="100" height="45" />
      <div>&#174; Marca Registrada</div>
</footer>
</body>

