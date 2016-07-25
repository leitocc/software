<?php

require_once './Conexion.php';

/*caturamos nuestros datos que fueron enviados desde el formulario mediante el metodo POST
**y los almacenamos en variables.*/

$usuario = filter_input(INPUT_POST, "usuario");
$password = filter_input(INPUT_POST, "clave");
//$usuario = $_POST["usuario"];   
//$password = $_POST["clave"];
$query = "SELECT U.usuario, U.password, P.nombre, P.apellido, R.nombre AS rol, R.id_rol "
        . "FROM usuario U INNER JOIN persona P "
        . "ON U.id_persona = P.id_persona "
        . "INNER JOIN rol R ON P.id_rol = R.id_rol "
        . "WHERE U.usuario = \"".$usuario."\"";

$result = mysql_query($query);
//Validamos si el nombre del administrador existe en la base de datos o es correcto
if(mysql_errno() == 0){
 $row = mysql_fetch_array($result);
//Si el usuario es correcto ahora validamos su contraseña
 if($row["password"] == $password)
 {
 
//if($usuario === "admin" && $password === "admin")
//{
  //Creamos sesión
  session_start();  
  //Almacenamos el nombre de usuario en una variable de sesión usuario
  $_SESSION['usuario'] = $usuario;  
  $_SESSION['nombreUS'] = $row["nombre"];  
  $_SESSION['apellidoUS'] = $row["apellido"];  
  $_SESSION['rolUS'] = $row["rol"];  
  $_SESSION['idRolUS'] = $row["id_rol"];  
  
  //Redireccionamos a la pagina: index.php
  header("Location: index.php");  
 }
 else
 {
  //En caso que la contraseña sea incorrecta enviamos un msj y redireccionamos a login.php
  ?>
   <script languaje="javascript">
    alert("Nombre de usuario y/o contraseña incorrecta");
    location.href = "login.php";
   </script>
  <?php
 }
}else{
   ?>
   <script languaje="javascript">
    alert("Nombre de usuario y/o contraseña incorrecta2 <?php echo $usuario." - "-$password ?>");
    location.href = "login.php";
   </script>
   <?php 
}
//Mysql_free_result() se usa para liberar la memoria empleada al realizar una consulta
mysql_free_result($result);

/*Mysql_close() se usa para cerrar la conexión a la Base de datos y es 
**necesario hacerlo para no sobrecargar al servidor, bueno en el caso de
**programar una aplicación que tendrá muchas visitas ;) .*/
mysql_close();
