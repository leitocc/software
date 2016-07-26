<?php
session_start();
try{
    require_once '../../Conexion2.php';
    $mensajecomponente= "";
    $idComponenteSoftware=filter_input(INPUT_POST, "componenteSoftware");
    
    $query24="DELETE from componente_software where idComponente_Software=".$idComponenteSoftware.";"; 
    echo $query24;
    $consulta=$mysqli->query($query24);
    $mensajecomponente="Se elimino correctamente";
}catch (mysqli_sql_exception $myE){
    $mensajecomponente = "Error al eliminar en la BD: ".$myE;
}catch (Exception $e){
    $mensajecomponente = "Error general: ". $e;
}
echo $mensajecomponente;
header('Location: /IncidentesSoftware/Administracion/PrincipalAdministracion.php');
$_SESSION['mensaje'] = $mensajecomponente;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



