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
    $sql = "UPDATE entrevistas SET mesa='{$mysqli->real_escape_string($_POST['mesa'])}', fecha='{$mysqli->real_escape_string($_POST['fecha'])}', entrevistado ='{$mysqli->real_escape_string($_POST['entrevistado'])}',entrevistador='{$mysqli->real_escape_string($_POST['entrevistador'])}', entrevista='{$mysqli->real_escape_string($_POST['entrevista'])}' WHERE id='{$mysqli->real_escape_string($_REQUEST['id'])}'";
    $result = $mysqli->query($sql);
  // Print response from MySQL
  if ($result) {
    header ("location: Entrevistas.php");
    
  } else {
    echo "Error al modificar";
  }
  }
?>