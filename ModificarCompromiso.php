<?php header('Content-Type: text/html; charset=UTF-8');?>
<?php 

if ( isset( $_POST['btnUpload'] )  ) {
 // Connect to MySQL
  $mysqli = new mysqli( 'localhost', 'root', 'juan', 'mqabeneficios' );  
  // Check our connection
  if ( $mysqli->connect_error ) {
    die( 'Connect Error: ' . $mysqli->connect_errno . ': ' . $mysqli->connect_error );

   $id=$_REQUEST['id'];
 
    
  }
 // Update Data
    $sql = "UPDATE compromiso SET compromiso='{$mysqli->real_escape_string($_POST['compromiso'])}', responsable='{$mysqli->real_escape_string($_POST['responsable'])}', cargo='{$mysqli->real_escape_string($_POST['cargo'])}',fecha='{$mysqli->real_escape_string($_POST['fecha'])}' WHERE id='{$mysqli->real_escape_string($_REQUEST['id'])}'";
    $result = $mysqli->query($sql);
  // Print response from MySQL
  if ($result) {
    header ("location: Compromiso.php");
    
  } else {
    echo "Error al modificar";
  }
  }
?>