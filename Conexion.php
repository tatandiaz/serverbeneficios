        <?php
        $servidor = "localhost";
        $basedatos = "mqabeneficios";
        $usuario = "root";
        $contrasena = "juan";
        $mysqli =   new mysqli($servidor,$usuario,$contrasena,$basedatos);
        if ($mysqli -> connect_errno) {
        die( "Fallo la conexión a MySQL: (" . $mysqli -> mysqli_connect_errno(). ") " . $mysqli -> mysqli_connect_error());
        }
        else{
        echo "";
        }
        ?>
      