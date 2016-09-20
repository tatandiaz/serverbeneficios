<?php header('Content-Type: text/html; charset=UTF-8');?>

 <a href="./" class="btnReturn">AREA DE TRABAJO</a>
<?php 
  if ( isset( $_POST['btnGuardarCliente'] )  ) {

  // Connect to MySQL
  $mysqli = new mysqli( 'localhost', 'root', 'juan', 'mqabeneficios' );

  // Check our connection
  if ( $mysqli->connect_error ) {
  die( 'Connect Error: ' . $mysqli->connect_errno . ': ' . $mysqli->connect_error );
  }

  // Insert our data
  $sql = "INSERT INTO CreaCliente (nombre) VALUES ( '{$mysqli->real_escape_string($_POST['nameNombre'])}')";
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

<form id='tablaOculta' action="DelCreaCliente.php" style='display:block;' method="POST">
<strong class="TitleVerCatCliente" >LISTA CATEGORIA DE CLIENTE</strong>
    <table border="1" class="tablaEstrategia" >
      <tr class="encabezados">
        <th>Nombre categoria cliente</th>
        
        <th class="CeldaEliminar"><input class="StyleBotonEliminar" type="submit" name="btnEliminarCliente" value="X"/></th>
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
           <td class="CeldaEliminar"><input type="checkbox" name="capturaids[]" value=" <?php echo $columna['id'];?> "></td>
        </tr>

      <?php endwhile; ?>
    </table>
</form>

    
