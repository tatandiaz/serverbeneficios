<?php header('Content-Type: text/html; charset=UTF-8');?>

<TITLE>PRIORIDAD</TITLE>
<link rel="stylesheet" type="text/css" href="Mycss.css">
  <body class="body">
    <?php
require_once("funciones.php");
?>

    <script src="jquery-1.10.2.min.js"></script>
     <a href="./" class="btnReturn">AREA DE TRABAJO</a> 
    <form  action="Prioridad.php" method="POST">
      <strong class="TitlePrioridad" >PRIORIDAD</strong>
      <fieldset class="styleFromPrioridad">
        <legend class="labelPrioridad" ></legend>
        <div>
          <table width="503" border="0">
     
              <td>

              </td>
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
                <select name="mesa" id="mesa" class="camposPrioridad">
                  <option value=""> Seleccione la mesa </option>
                  <?php
		$estados = dameEstado();
		
		foreach($estados as $indice => $registro){
			echo "<option value='".$registro['id']."  ".$registro['nombre']."'>".$registro['nombre']."</option>";
		}
		?>
                </select>
                <br>
                  <br>
                    <select name="proceso" id="proceso" class="camposPrioridad" >
                      <option value=""> Primero seleccione la mesa </option>
                    </select>
                  </td>
            </tr>
                <tr>
              <td>

              </td>

              <td>
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
        $consulta = 'SELECT id, priorizacion FROM creapriorizacion ORDER BY priorizacion ASC';
        $resultado=mysqli_query ($mysqli, $consulta); 
        ?>
            <br>
                  
          <select name="CampNombres" class="CamposPrioridadNombrephp">
          <option>Seleccione nivel de prioridad</option>"; 
            <?php
            while ($fila=mysqli_fetch_row($resultado)){     
            echo "<option value='".$fila['1']."'>".$fila['1']."</option>";  
            }
            ?>  
      </select> 
              </td>
            </tr>
            <tr>

          </table>
          <input class="btnGuardarPrioridad" type="submit" name="btnPrioridad" value="GUARDAR"/>
          <input type="button" id="btnMostrar" class="btnVerPrioridad" onclick="mostrartablaPrioridad()"  value="VER REGISTROS"></input>

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

if ( isset( $_POST['btnPrioridad'] )  ) {
  
  // Connect to MySQL
  $mysqli = new mysqli( 'localhost', 'root', 'juan', 'mqabeneficios' );
  
  // Check our connection
  if ( $mysqli->connect_error ) {
    die( 'Connect Error: ' . $mysqli->connect_errno . ': ' . $mysqli->connect_error );
  }

 // Insert our data
  $sql = "INSERT INTO prioridad (nombre, mesa, proceso ) VALUES ( '{$mysqli->real_escape_string($_POST['CampNombres'])}', '{$mysqli->real_escape_string($_POST['mesa'])}', '{$mysqli->real_escape_string($_POST['proceso'])}')";
  $insert = $mysqli->query($sql);
  
  // Print response from MySQL
  if ( $insert ) {
    echo '<script language="javascript">alert("NIVEL DE PRIORIDAD GUARDADO");</script>';
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
    <form  id='tablaOculta' action="DeletePrioridad.php" style='display:none;' method="POST">
      <table border="1" class="tablaPrioridad" >
        <tr class="encabezados">
          <th>NIVEL DE PRIORIDAD</th>
          <th>MESA</th>
          <th>PROCESO</th>
           <th class="CeldaEliminar"><input class="StyleBotonEliminar" type="submit" name="btnEliminarPrioridad" value="X"/></th>
          </th>
        </tr>
        <?php
$sql = "SELECT * FROM prioridad";
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
      function mostrartablaPrioridad(){
      document.getElementById('tablaOculta').style.display ='block';}
    </script>

    <footer class="fotterMQA">
      <img src="temas/img/mqa.png" width="100" height="45" />
      <div>&#174; Marca Registrada</div>

    </footer>

  </body>



