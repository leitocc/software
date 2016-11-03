<?php
session_start();
$permisos = array("6", "1");
$_SESSION['permisos'] = $permisos;
include_once '../../../verificarPermisos.php';
require_once '../../../Componente.class.php';
require_once '../../../DetalleComponente.class.php';
require_once '../../../Conexion.php';
$modo = filter_input(INPUT_GET, "modo");
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Sistema de Gestion de Incidentes</title>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery-ui.js"></script>
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/estilo.css" />
        <?php
        $tipoComponente = filter_input(INPUT_GET, "tipoComponente");
        $idTipoComponente = filter_input(INPUT_GET, "idTipoComponente");
        $Detalle = 0;
        $vectorDetalles = array();
        $buscarDetalle = array();
        echo $idTipoComponente;
        switch ($idTipoComponente) {
            case 1:
                $vectorDetalles = array(3, 5);
                break;
            case 2:
                $vectorDetalles = array(3);
//                            $vectorDetalles[0] = 3;
                break;
            case 3:
                $vectorDetalles = array(3);
//                            $vectorDetalles[0] = 3;
                break;
            case 4:
                break;
            case 5:
                $vectorDetalles = array(
                    0 => 1,
                    1 => 2,
                    2 => 4
                );
//                            $vectorDetalles[0] = 1;
//                            $vectorDetalles[1] = 2;
//                            $vectorDetalles[2] = 4;
                break;
            case 6:
                $vectorDetalles = array("1", "2", "3");
                echo "aqui entra<br/>";
//                            $vectorDetalles[0] = 1;
//                            $vectorDetalles[1] = 2;
//                            $vectorDetalles[2] = 3;
                break;
            case 7:
                break;
            case 8:
                $vectorDetalles = array("2");
//                            $vectorDetalles[0] = 2;
                break;
            case 9:
                $vectorDetalles = array("1", "10");
//                            $vectorDetalles[0] = 1;
//                            $vectorDetalles[1] = 10;
                break;
            case 10:
                break;
            case 11:
                $vectorDetalles = array("8");
//                            $vectorDetalles[0] = 8;
                break;
            case 13:
                $vectorDetalles = array("6", "7");
//                            $vectorDetalles[0] = 6;
//                            $vectorDetalles[1] = 7;
                break;
            case 14:
                $vectorDetalles = array("11");
//                            $vectorDetalles[0] = 11;
                break;
            default :
                break;
        }
        echo print_r($vectorDetalles) . "<br/>";
        if ($modo == "ins") {
            $titulo = "Registrar " . $tipoComponente;
            $Comp = new Componente();
            $Detalle = new DetalleComponente();
//                        $buscarIdComponente = mysql_query("SELECT id_tipo_componente "
//                                . "FROM tipo_componente WHERE descripcion = \"".$componente."\";");
//                        if(mysql_num_rows($buscarIdComponente) == 0){
//                            exit();
//                        }
//                        $row = mysql_fetch_row($buscarIdComponente);
//                        $id = $row[0];
        } else {
            $titulo = "Modificar " . $tipoComponente;
            $idComponente = filter_input(INPUT_GET, "idComponente");
            $queryDet = "SELECT c.id_componente as id , c.id_tipo_componente, c.descripcion as modelo, c.id_marca AS marca, "
                    . "c.nro_patrimonio as patrimonio, c.nro_serie as serie, c.anio_adquisicion as anio, "
                    . "c.mes_adquisicion as mes FROM componente c WHERE c.id_sistema_informatico =" . $_SESSION['si'] . " "
                    . "AND c.baja = 0 AND c.id_componente = " . $idComponente; //Aqui se debe poner el id del componente no del tipo de comp
            echo $queryDet . "<br/>";
            $consultaDetalles = mysql_query($queryDet);
            if (mysql_num_rows($consultaDetalles) == 0) {
                $Comp = new Componente();
                $Detalle = new DetalleComponente();
            } else {
                while ($row = mysql_fetch_array($consultaDetalles)) {
                    $Comp = new Componente();
                    $Comp->setId_componente($row['id']);
                    $Comp->setDescripcion($row['modelo']);
                    $Comp->setId_marca($row['marca']);
                    $Comp->setAño($row['anio']);
                    $Comp->setMes($row['mes']);
                    $Comp->setNro_patrimonio($row['patrimonio']);
                    $Comp->setNro_serie($row['serie']);

                    $index = 0;
                    foreach ($vectorDetalles as $idDescripcion) {
                        $queryBuscarDetalle = "SELECT  D.valor, D.valor_alfanumerico, UM.descripcion AS unidad, DE.nombre AS descripcion"
                                . "FROM detalle_componente D inner join componente C on (D.id_componente=C.id_componente) "
                                . "INNER JOIN descripcion_detalle_componente DE ON D.id_descipcion = DE.id_descripcion_detalle_componente "
                                . "INNER JOIN unidad_medida UM ON D.id_unidad_medida = UM.id_unidad_medida"
                                . "WHERE C.id_sistema_informatico = " . $_SESSION['si'] . " "
                                . "AND D.id_descipcion = " . $idDescripcion . " AND C.baja = 0 AND C.id_componente = " . $idComponente;
                        $buscarDetalle[index] = mysql_query($queryBuscarDetalle);
                        $index++;
                        //echo $queryBuscarDetalle."<br/>";
                        if (mysql_num_rows($buscarDetalle) == 0) {
                            $Detalle = new DetalleComponente();
                        }
                        //}else{
                        //}
                        //$detalles[$index] = $Detalle;
                    }
                }
            }
        }
        ?>
        <script>
            $(document).ready(function () {
                $("#anio").spinner();
                $("#Volver").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/CPU/PaginaCPUSegunda.php';
                });
            });
        </script>
    </head>

    <body id="top">
<?php include_once '../../../master.php'; ?>
        <div id="site">
            <div class="center-wrapper">
<?php include_once '../../../menu.php'; ?>

                <div class="main">
                    <div class="post">


                        <form action="<?php echo $pagina ?>" method="post" name="formulario" class="contact_form">
                            <li><h2><?php echo $titulo ?></h2><span class="required_notification">Los campos con (*) son obligatorios</span></li>
                            <div style="width: 600px;">
                                <table>
                                    <tr>
                                        <td> Sistema Informatico</td>
                                        <td><input name="SI" type="text" maxlength="20" readonly="true" value="<?php echo $_SESSION['si'] ?>" required/>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Marca</td>
                                        <td>
<?php $consulta = mysql_query("select * from marca"); ?>
                                            <select name='marca' id="marca" required>
                                                <option value="" >Seleccione...</option>
<?php while ($row = mysql_fetch_array($consulta)) { ?>
                                                    <option value ="<?php echo $row['id_marca']; ?>" <?php if ($row['id_marca'] == $Comp->getId_marca()) {
        echo 'selected="true"';
    }
    ?>> <?php echo $row['descripcion'] ?> </option>
                                                        <?php } ?>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td> Modelo</td>
                                        <td><input name="modelo" id="modelo" type="text" maxlength="20" value="<?php echo $Comp->getDescripcion() ?>" required/></td>
                                    </tr>

                                    <tr>
                                        <td>Numero de serie</td>
                                        <td><input name="nroSerie" id="nroSerie" type="text" size="50" maxlength="100" value="<?php echo $Comp->getNro_serie() ?>"/></td>
                                    </tr>

                                    <tr>
                                        <td>Mes de adquisicion </td>
                                        <td>  
                                            <select name="mes" id="mes" required>
                                                <option value="" >Seleccione...</option>
                                                <?php $mes = $Comp->getMes() ?>
                                                <option value="1" <?php if (1 == $mes) {
                                                    echo 'selected="true"';
                                                }
                                                ?>> Enero</option>
                                                <option value="2" <?php if (2 == $mes) {
                                                    echo 'selected="true"';
                                                }
                                                ?>> Febrero</option>
                                                <option value="3" <?php if (3 == $mes) {
                                                    echo 'selected="true"';
                                                }
                                                ?>> Marzo</option>
                                                <option value="4" <?php if (4 == $mes) {
                                                    echo 'selected="true"';
                                                }
                                                ?>> Abril</option>
                                                <option value="5" <?php if (5 == $mes) {
                                                    echo 'selected="true"';
                                                }
                                                ?>> Mayo</option>
                                                <option value="6" <?php if (6 == $mes) {
                                                    echo 'selected="true"';
                                                }
                                                ?>> Junio</option>
                                                <option value="7" <?php if (7 == $mes) {
                                                    echo 'selected="true"';
                                                }
                                                ?>> Julio</option>
                                                <option value="8" <?php if (8 == $mes) {
                                                    echo 'selected="true"';
                                                }
                                                ?>> Agosto</option>
                                                <option value="9" <?php if (9 == $mes) {
                                                    echo 'selected="true"';
                                                }
                                                ?>> Septiembre</option>
                                                <option value="10" <?php if (10 == $mes) {
                                                    echo 'selected="true"';
                                                }
                                                ?>> Octubre</option>
                                                <option value="11" <?php if (11 == $mes) {
                                                    echo 'selected="true"';
                                                }
                                                ?>> Noviembre</option>
                                                <option value="12" <?php if (12 == $mes) {
                                                    echo 'selected="true"';
                                                }
                                                ?>> Diciembre</option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Año adquisición</td>
                                        <td><input id="anio" name="año" value="<?php echo $Comp->getAño() ?>" required/></td>
                                    </tr>


                                    <tr>
                                        <td>Proveedor</td>
                                        <td>    <?php $consulta = mysql_query("select * from proveedor"); ?>
                                            <select name='proveedor' id="proveedor"> 
                                                <option value="" >Seleccione...</option>
                                    <?php while ($row = mysql_fetch_array($consulta)) { ?>
                                                    <option value ="<?php echo $row['id_proveedor'] ?>"><?php echo $row['nombre'] ?> </option>
                                    <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <?php
                                    if ($Detalle === 0) {
                                        echo "Entro: 1<br/>";
                                        foreach ($buscarDetalle as $buscarDetalleResult) {
                                            echo "Entro: 2<br/>";
                                            while ($row = mysql_fetch_array($buscarDetalleResult)) {
                                                $valor = $row['valor'];
                                                if ($valor === NULL || $valor === "") {
                                                    $valor = $row['valor_alfanumerico'];
                                                }
                                                ?>
                                                <tr>
                                                    <td><?php echo $row['descripcion'] ?></td>
                                                    <td>
                                                        <input type="text" name="<?php echo $row['descripcion'] ?>" value="<?php echo $valor ?>" required/> <?php echo $row['unidad'] ?>
                                                    </td>
                                                </tr>
            <?php
        }
    }
} else {
    foreach ($vectorDetalles as $idDescripcion) {
        //echo "Entro: 5<br/>";
        $queryNombreDescripcion = "SELECT DDC.nombre 
                        FROM descripcion_detalle_componente DDC 
                        WHERE DDC.id_descripcion_detalle_componente = " . $idDescripcion;
        $buscarNombreDescripcion = mysql_query($queryNombreDescripcion);
        while ($row = mysql_fetch_array($buscarNombreDescripcion)) {
            ?>
                                                <tr>
                                                    <td><?php echo $row['nombre'] ?></td>
                                                    <td>
                                                        <input type="text" name="<?php echo $row['nombre'] ?>" value="" required/> 
                                                    </td>
                                                </tr>
            <?php
        }
    }
}
?>


                                </table>
                            </div>
                            <button class="submit" name="volver" id="Volver">Volver</button>
                            <button class="submit" name="Registrar">Registrar</button>
<?php
$idSub = filter_input(INPUT_GET, "idSub");
if ($idSub != NULL) {
    ?>
                                <input  type="hidden" name="idSub" value="<?php echo $idSub ?>"/>
<?php } ?>
                        </form>
                    </div>
                </div>
<?php include_once '../../../foot.php'; ?>
            </div>
        </div>
    </body>
</html>