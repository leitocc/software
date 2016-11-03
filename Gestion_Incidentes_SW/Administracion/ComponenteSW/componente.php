<?php
session_start();
try{
    require_once '../../Conexion2.php';
    $mensajecomponente= "";
    $descripcion=filter_input(INPUT_POST, "descripcion");
    $tipoComponente=filter_input(INPUT_POST, "tipo_componente_software");
    $version=filter_input(INPUT_POST, "version");
    $query22="INSERT INTO componente_software (id_tipo_componente,descripcion,version) values(".$tipoComponente.",'".$descripcion."','".$version."');";
    echo $query22;
    $consulta=$mysqli->query($query22);
    $mensajecomponente="se registro correctamente";
    $msj = 1;
}catch (mysqli_sql_exception $myE){
    $mensajecomponente = "Error al grabar en la BD: ".$myE;
    $msj = 2;
}catch (Exception $e){
    $mensajecomponente = "Error general: ". $e;
    $msj = 2;
}
echo $mensajecomponente;
header('Location: /' . $_SESSION['RELATIVE_PATH'] . '/Administracion/PrincipalAdministracion.php?msj=' . $msj . '');
$_SESSION['mensaje'] = $mensajecomponente;
//echo $mensajecomponente . ": ". $msj ;
