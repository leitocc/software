<?php
session_start();
$permisos = array("6", "1");
$_SESSION['permisos'] = $permisos;
include_once '../../verificarPermisos.php';
require_once '../../Componente.class.php';
require_once '../../DetalleComponente.class.php';
require_once '../../Conexion2.php';

$modo = filter_input(INPUT_GET, "mod");
$_SESSION['modo'] = $modo;
if (is_null($modo) || $modo === "ins" || $modo !== "mod") {
    //tomar el idSI y el idTC y armar el formulario
    $idSI = filter_input(INPUT_GET, "idSI");
    $idTC = filter_input(INPUT_GET, "idTC");
    $titulo = "Registrar nuevo componente";
    $_SESSION['componente'] = new Componente();
    $_SESSION['detalles'] = null;
    $_SESSION['idTC'] = $idTC;
} elseif ($modo === "mod") {
    //aqui deberia tomar el idC y hacer consulta
    $idC = filter_input(INPUT_GET, "idC");
    //armar el Componente y el DetalleComponente
    $queryBuscarComponente = "SELECT c.id_componente as id ,c.descripcion as modelo, c.id_marca AS marca, "
            . "c.nro_patrimonio as patrimonio, c.nro_serie as serie, c.anio_adquisicion as anio, "
            . "c.mes_adquisicion as mes, c.id_tipo_componente FROM componente c WHERE c.id_componente =" . $idC;
    //echo $queryBuscarComponente;
    $resultado = $mysqli->query($queryBuscarComponente);
    $titulo = "Modificar componente";
    if ($resultado->num_rows === 0) {
        $Comp = new Componente();
        $Detalles[] = null;
    } else {
        while ($row = $resultado->fetch_assoc()) {
            $Comp = new Componente();
            $Comp->setId_componente($row['id']);
            $Comp->setDescripcion($row['modelo']);
            $Comp->setId_marca($row['marca']);
            $Comp->setAño($row['anio']);
            $Comp->setMes($row['mes']);
            $Comp->setNro_patrimonio($row['patrimonio']);
            $Comp->setNro_serie($row['serie']);
            $_SESSION['idTC'] = $row['id_tipo_componente'];
            $queryBuscarDetalle = "SELECT  D.id_detalle_componente, "
                    . "D.id_descipcion, D.valor, D.valor_alfanumerico, D.id_unidad_medida "
                    . "FROM detalle_componente D "
                    . "INNER JOIN componente C ON (D.id_componente = C.id_componente) "
                    . "WHERE C.id_componente = " . $idC;
            $buscarDetalle = $mysqli->query($queryBuscarDetalle);
//            echo $queryBuscarDetalle."<br/>";
            if ($buscarDetalle->num_rows === 0) {
                $Detalles[] = null;
            } else {
                $i = 0;
                while ($row1 = $buscarDetalle->fetch_assoc()) {
                    $Detalles[$i] = new DetalleComponente();
                    $Detalles[$i]->setId_detalle($row1['id_detalle_componente']);
                    $Detalles[$i]->setId_componente($idC);
                    $Detalles[$i]->setId_descripcion($row1['id_descipcion']);
                    $Detalles[$i]->setValor($row1['valor']);
                    $Detalles[$i]->setValor_alfanumerico($row1['valor_alfanumerico']);
                    $Detalles[$i]->setId_unidad_medida($row1['id_unidad_medida']);
                    $i++;
                }
            }
            break;
        }
    }
    $_SESSION['componente'] = $Comp;
    $_SESSION['detalles'] = $Detalles;
}
//El modo ELIMINAR no se programa en esta página
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sistema de Gestion de Incidentes</title>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery-ui.js"></script>
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/estilo.css" />
        <script>
            $(document).ready(function () {
                $("#anio").spinner();
                $("#volver").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/ComponentesSI.php';
                });
                $("#nroInventario").attr("disabled", true);
                if ($("#nroInventario").val() !== "") {
                    $("#nroInventario").attr("disabled", false);
                    $("#invSI").attr("checked", true);
                } else {
                    $("#invNO").attr("checked", true);
                }
                $("#invSI").click(function () {
                    $("#nroInventario").attr("disabled", false);
                });
                $("#invNO").click(function () {
                    $("#nroInventario").html(" ");
                    $("#nroInventario").attr("disabled", true);
                });
            });
        </script>
    </head>

    <body id="top">
        <?php include_once '../../master.php'; ?>
        <div id="site">
            <div class="center-wrapper">
                <?php include_once '../../menu.php'; ?>
                <div class="main">
                    <div class="post">
                        <form action="ManejadorComponentesHW.php" method="post" name="formulario" class="contact_form">
                            <li><h2><?php echo $titulo . " " . $_SESSION['si'] ?></h2><span class="required_notification">Los campos con (*) son obligatorios</span></li>
                            <div style="width: 900px;">
                                <?php
                                include_once './detallesGenericos.php';
                                ?>
                                <li class="no_lista">
                                    <button class="submit" type="submit" id="volver">Volver</button>
                                <?php
                                if($_SESSION['modo'] == "mod"){
                                    print '<button class="submit" type="submit" id="registrar">Modificar</button>';
                                }else{
                                    print '<button class="submit" type="submit" id="registrar">Registrar</button>';
                                }
                                ?>
                                </li> 
                            </div>
                            
                        </form>
                    </div>
                </div>
                <?php include_once '../../../foot.php'; ?>
            </div>
        </div>
    </body>
