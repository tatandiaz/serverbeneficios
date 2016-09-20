<?php header('Content-Type: text/html; charset=UTF-8');?>
<link rel="shortcut icon" href="temas/img/mqa.png">
<link rel="stylesheet" type="text/css" href="Mycss.css"> 
<body class="body">

  <?php
      $id=$_REQUEST['id'];

  // Connect to MySQL
  $mysqli = new mysqli( 'localhost', 'root', 'juan', 'mqabeneficios' );
  
  // Check our connection
  if ( $mysqli->connect_error ) {
    die( 'Connect Error: ' . $mysqli->connect_errno . ': ' . $mysqli->connect_error );
  }
 

$sql = "SELECT * FROM entrevistas WHERE id='$id'";
$result = $mysqli->query($sql);
$columna = $result->fetch_assoc();
    ?>

<form   method="POST"  action="ModificarEntrevista.php?id=<?php echo $columna['id']; ?>"  >
   <strong class="titleModificarEntrevista">MODIFICAR ENTREVISTA</strong>

  <fieldset class="styleFromModificacionEntrevista">
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
          <select name="mesa" class="selectEntrevistasModificacion">
          <option>Selecciona la mesa</option>
            <?php
            while ($fila=mysqli_fetch_row($resultado)){     
            echo "<option value='".$fila['1']."'>".$fila['1']."</option>";  
            }
            ?>  
      </select>    
        </td>
    <br/><br/>
    <input type="date"  class="labelPlaceholderModificacion" name="fecha" value="<?php  echo $columna ['fecha']  ?>"/>
    <br/><br/>
    <input type="text" class="labelPlaceholderModificacion" placeholder="Entrevistado" name="entrevistado"  value="<?php  echo $columna ['entrevistado']  ?>"/>
    <br/><br/>
    <input type="text"  class="labelPlaceholderModificacion" placeholder="Entrevistador" name="entrevistador"  value="<?php  echo $columna ['entrevistador']  ?>"/>
    <br/><br/>
    <input type="text"  class="labelPlaceholderModificacion" placeholder="Entrevista" name="entrevista"  value="<?php  echo $columna ['entrevista']  ?>"/>
    <br/><br/>
    <input class="btnModificarEntrevista" type="submit" name="btnUpload" value="MODIFICAR" />
</fieldset>
</form>
</body>