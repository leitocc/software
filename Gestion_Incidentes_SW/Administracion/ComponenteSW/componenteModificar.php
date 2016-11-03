<?php
session_start();
try{
    require_once '../../Conexion2.php';
    $mensajecomponente= "";
    $idComponenteSoftware=filter_input(INPUT_POST, "componenteSoftware");
    $descripcion=filter_input(INPUT_POST, "descripcion");
    $tComponente=filter_input(INPUT_POST, "tipo_componente_software");
    $tVersion=filter_input(INPUT_POST, "version");
    if($tVersion == ""){
        $tVersion = "NULL";
    }
    $query24="UPDATE componente_software set descripcion= '".$descripcion."', id_tipo_componente=".$tComponente.", version=".$tVersion." where idComponente_Software=".$idComponenteSoftware.";"; 
    echo $query24;
    $consulta=$mysqli->query($query24);
    if($consulta){
        $mensajecomponente="Se Actualizo correctamente";
        $msj = 1;
    }else{
        $msj = 2;
    }
}catch (mysqli_sql_exception $myE){
    $mensajecomponente = "Error al eliminar en la BD: ".$myE;
    $msj = 2;
}catch (Exception $e){
    $mensajecomponente = "Error general: ". $e;
    $msj = 2;
}
echo $mensajecomponente;
header('Location: /' . $_SESSION['RELATIVE_PATH'] . '/Administracion/PrincipalAdministracion.php?msj=' . $msj . '');
$_SESSION['mensaje'] = $mensajecomponente;


