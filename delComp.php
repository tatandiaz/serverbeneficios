<?php

// Connect to MySQL
  $mysqli = new mysqli( 'localhost', 'root', 'juan', 'mqabeneficios' );
  
  // Check our connection
  if ( $mysqli->connect_error ) {
    die( 'Connect Error: ' . $mysqli->connect_errno . ': ' . $mysqli->connect_error );
  }

  if (isset($_POST['btnEliminar'])){

    foreach($_POST['capturaids'] as $capturaid){
    $result = $mysqli->query('DELETE FROM compromiso WHERE id ='.$capturaid);

    }
    header ('Location: ../ServerBeneficios/Compromiso.php');

  }

?>