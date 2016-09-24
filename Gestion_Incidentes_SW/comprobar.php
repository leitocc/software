<?php
require_once './Conexion2.php';

/* caturamos nuestros datos que fueron enviados desde el formulario mediante el metodo POST
 * *y los almacenamos en variables. */

$usuario = filter_input(INPUT_POST, "usuario");
$password = filter_input(INPUT_POST, "clave");
//$usuario = $_POST["usuario"];   
//$password = $_POST["clave"];
$query = "SELECT U.id_persona, U.usuario, U.password, P.nombre, P.apellido, R.nombre AS rol, R.id_rol "
        . "FROM usuario U INNER JOIN persona P "
        . "ON U.id_persona = P.id_persona "
        . "INNER JOIN rol R ON P.id_rol = R.id_rol "
        . "WHERE U.usuario = \"" . $usuario . "\"";
//echo $query;
$resultUsuario = $mysqli->query($query);
//Validamos si el nombre del administrador existe en la base de datos o es correcto
if ($row = $resultUsuario->fetch_assoc()) {

//Si el usuario es correcto ahora validamos su contraseña
    if ($row["password"] == $password) {

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
        $_SESSION['idPersona'] = $row["id_persona"];

        //Redireccionamos a la pagina: index.php
        header("Location: index.php");
    } else {
        //En caso que la contraseña sea incorrecta enviamos un msj y redireccionamos a login.php
        ?>
        <script languaje="javascript">
            alert("Nombre de usuario y/o contraseña incorrecta");
            location.href = "login.php";
        </script>
        <?php
    }
} else {
    ?>
    <script languaje="javascript">
        alert("Nombre de usuario y/o contraseña incorrecta");
        location.href = "login.php";
    </script>
    <?php
}
$resultUsuario->free;