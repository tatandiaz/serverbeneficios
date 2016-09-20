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
 

$sql = "SELECT * FROM compromiso WHERE id='$id'";
$result = $mysqli->query($sql);
$columna = $result->fetch_assoc();
    ?>

<form   method="POST"  action="ModificarCompromiso.php?id=<?php echo $columna['id']; ?>"  >
   <strong class="titleModificarCompromiso">MODIFICAR COMPROMISO</strong>

  <fieldset class="styleFromModificacion">
  <legend ></legend>
  
    <br/>
    
    <textarea class="labelCompEdit" name="compromiso" rows="5" cols="5"  value="<?php  echo $columna ['compromiso']  ?>"><?php  echo $columna ['compromiso']  ?></textarea>
    <br/> <br/>
    
    <input type="text" class="labelPlaceholderModificacion" placeholder="Responsable" name="responsable"  value="<?php  echo $columna ['responsable']  ?>"/>
  <br/>
    <br/>
    <input type="text"  class="labelPlaceholderModificacion" placeholder="Cargo" name="cargo"  value="<?php  echo $columna ['cargo']  ?>"/>
    <br/>
   
    <br/>
    <input type="date"  class="labelPlaceholderModificacion" name="fecha" value="<?php  echo $columna ['fecha']  ?>"/>
    <br/>
    
    <input class="btnModificarCompromiso" type="submit" name="btnUpload" value="MODIFICAR" />
  
</fieldset>

  
</form>

</body>