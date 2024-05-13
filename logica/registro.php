<?php
    require 'conexion.php';
  
    $sql = "INSERT INTO usuarios (user, pass, Correo, Permisos) VALUES ('Hola ', ' hola', 'a@gmai.com', '1')";
 
    mysqli_query($conexion, $sql);
    
?>
