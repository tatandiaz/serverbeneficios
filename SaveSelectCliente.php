<?php header('Content-Type: text/html; charset=UTF-8');?>
<a href="./"><img src="temas/img/return.png" class="btnReturn"></a>
<?php 
  if ( isset( $_POST['btnCategoriaCliente'] )  ) {

  // Connect to MySQL
  $mysqli = new mysqli( 'localhost', 'root', 'juan', 'mqabeneficios' );

  // Check our connection
  if ( $mysqli->connect_error ) {
  die( 'Connect Error: ' . $mysqli->connect_errno . ': ' . $mysqli->connect_error );
  }

  // Insert our data
  $sql = "INSERT INTO categoriacliente (nombre,mesa,proceso) VALUES ( '{$mysqli->real_escape_string($_POST['CampNombre'])}',,'{$mysqli->real_escape_string($_POST[' CampMesas'])}','{$mysqli->real_escape_string($_POST['CampProcesos'])}')";
  $insert = $mysqli->query($sql);

  // Print response from MySQL
  if ( $insert ) {
  echo '<script language="javascript">alert("CATEGORIA CLIENTE GUARDADA CORRECTAMENTE");</script>';
  } else {
  die("Error: {$mysqli->errno} : {$mysqli->error}");
  }
header("Location:".$_SERVER['HTTP_REFERER']);  
}

?>
<?php header('Content-Type: text/html; charset=UTF-8');?>
<TITLE>Categoria Cliente</TITLE>

<link rel="stylesheet" type="text/css" href="Mycss.css"> 
<body class="body">

<form id='tablaOculta' action="test.php" style='display:block;' method="POST">
    <table border="1" class="tablaEstrategia" >
      <tr class="encabezados">
        <th>Nombre categoria cliente</th>
        
        <th class="CeldaEliminar"><input class="StyleBotonEliminar" type="submit" name="btnEliminarSelectCliente" value="X"/></th>
      </tr>
      
      <?php

  // Connect to MySQL
  $mysqli = new mysqli( 'localhost', 'root', 'juan', 'mqabeneficios' );
  
  // Check our connection
  if ( $mysqli->connect_error ) {
    die( 'Connect Error: ' . $mysqli->connect_errno . ': ' . $mysqli->connect_error );
  }

$sql = "SELECT * FROM CreaCliente";
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

    

?>