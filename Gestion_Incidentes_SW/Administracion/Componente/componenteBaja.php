<?php
session_start();
try{
    require_once '../../Conexion2.php';
    $mensajecomponente= "";
    $idComponenteSoftware=filter_input(INPUT_POST, "componenteSoftware");
    $descripcion=filter_input(INPUT_POST, "descripcion");
    $tComponente=filter_input(INPUT_POST, "tipo_componente_software");
    $tVersion=filter_input(INPUT_POST, "version");
    $query24="UPDATE componente_software set descripcion= '".$descripcion."', id_tipo_componente=".$tComponente.", version=".$tVersion." where idComponente_Software=".$idComponenteSoftware.";"; 
    echo $query24;
    $consulta=$mysqli->query($query24);
    if($consulta){
        $mensajecomponente="Se Actualizo correctamente";
        echo"<script type=\"text/javascript\">alert('Se actualizo correctamente'); "
        . "window.location='/IncidentesSoftware/SistemaInformatico/PrincipalSistemaInformatico.php';</script>";
        
    }else{
        
    }
    
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



