<?php
session_start();
$permisos = array("6", "1");
$_SESSION['permisos'] = $permisos;
include_once '../verificarPermisos.php';
require_once '../formatoFecha.class.php';
require_once '../Conexion2.php';
require_once '../Componente.class.php';
require_once '../DetalleComponente.class.php';
$Sistema = filter_input(INPUT_POST, "si");
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SGI-HW - Reportes</title>
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/estilo.css" />
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/tabla.css" />
    </head>
    <body id="top">
        <?php include_once '../master.php'; ?>
        <div id="site">
            <div class="center-wrapper">
                <?php include_once '../menu.php'; ?>

                <div class="main">
                    <div class="post">
                        <li class="no_lista"><h2>Sistema Informático <?php echo $Sistema ?></h2></li>
                        <?php
                        $buscarMarcas = $mysqli->query("SELECT id_marca, descripcion FROM marca");
                        $Marcas = array();
                        while ($marca = $buscarMarcas->fetch_assoc()) {
                            $Marcas[$marca['id_marca']] = $marca['descripcion'];
                        }
                        $buscarMarcas->free();
                        $buscarDescripciones = $mysqli->query("SELECT id_descripcion_detalle_componente AS id, nombre FROM descripcion_detalle_componente;");
                        $Descripciones = array();
                        while ($descripcion = $buscarDescripciones->fetch_assoc()) {
                            $Descripciones[$descripcion['id']] = $descripcion['nombre'];
                        }
                        $buscarDescripciones->free();
                        $buscarUnidades = $mysqli->query("SELECT id_unidad_medida AS id, descripcion FROM unidad_medida");
                        $Unidades = array();
                        while ($unidad = $buscarUnidades->fetch_assoc()) {
                            $Unidades[$unidad['id']] = $unidad['descripcion'];
                        }
                        $buscarUnidades->free();
                        ?>
                        <fieldset>
                            <legend><h3>Componentes</h3></legend>
                            <?php
                            $TiposComponentes = $mysqli->query("SELECT id_tipo_componente AS id, descripcion FROM tipo_componente");
                            $par = 0;
                            $banHayComponente = 0;
                            while ($tipoComponente = $TiposComponentes->fetch_assoc()) {
                                $queryComponente = "SELECT c.id_componente as id ,c.descripcion as modelo, c.id_marca AS marca, "
                                        . "c.nro_patrimonio as patrimonio, c.nro_serie as serie, c.anio_adquisicion as anio, "
                                        . "c.mes_adquisicion as mes FROM componente c WHERE c.id_sistema_informatico =" . $Sistema . " "
                                        . "and c.id_tipo_componente = " . $tipoComponente['id'] . " AND c.baja = 0";
                                $buscarComponente = $mysqli->query($queryComponente);
                                if ($mysqli->affected_rows == 0) {
                                    $Componente = NULL;
                                    $ListaDetalles = NULL;
                                } else {
                                    $banHayComponente = 1;
                                    while ($row = $buscarComponente->fetch_assoc()) {
                                        $Componente = new Componente();
                                        $Componente->setId_componente($row['id']);
                                        $Componente->setDescripcion($row['modelo']);
                                        $Componente->setId_marca($row['marca']);
                                        $Componente->setAño($row['anio']);
                                        $Componente->setMes($row['mes']);
                                        $Componente->setNro_patrimonio($row['patrimonio']);
                                        $Componente->setNro_serie($row['serie']);

                                        $queryBuscarDetalle = "SELECT id_descipcion AS descripcion, valor, "
                                                . "valor_alfanumerico, id_unidad_medida AS unidad "
                                                . "FROM detalle_componente WHERE id_componente = " . $Componente->getId_componente();
                                        $buscarDetalle = $mysqli->query($queryBuscarDetalle);
                                        $index = 0;
                                        if ($mysqli->affected_rows == 0) {
                                            $ListaDetalles = NULL;
                                        } else {
                                            $ListaDetalles = array();
                                            while ($row = $buscarDetalle->fetch_assoc()) {
                                                $DetalleComponente = new DetalleComponente();
                                                $DetalleComponente->setId_descripcion($row['descripcion']);
                                                $DetalleComponente->setValor($row['valor']);
                                                $DetalleComponente->setValor_alfanumerico($row['valor_alfanumerico']);
                                                $DetalleComponente->setId_unidad_medida($row['unidad']);
                                                $ListaDetalles[$index] = $DetalleComponente;
                                                $index++;
                                            }
                                        }
                                        $buscarDetalle->free();
                                        if ($Componente != NULL) {
                                            print '<div>';
                                            if ($par === 0) {
                                                print '<fieldset style="float: left; margin: 20px; width: 300px; height: 180px">';
                                                $par++;
                                            } else {
                                                print '<fieldset style="float: right; clear: right; margin: 20px; width: 300px; height: 180px">';
                                                $par = 0;
                                            }
                                            ?>
                                            <legend><h4><?php echo $tipoComponente['descripcion'] ?></h4></legend>
                                            <lu>
                                                <li>Modelo: <?php echo $Componente->getDescripcion() ?></li>
                                                <li>Marca: <?php echo $Marcas['2'] ?></li>
                                                <li>Adquisición: <?php echo formatoFecha::nombreMes($Componente->getMes()) . " " . $Componente->getAño(); ?></li>
                                                <li>Nro. Patrimonio: <?php echo $Componente->getNro_patrimonio() ?></li>
                                                <li>Nro. Serie: <?php echo $Componente->getNro_serie() ?></li>
                                                <?php
                                                if ($ListaDetalles != NULL) {
                                                    foreach ($ListaDetalles as $DetalleComponente) {
                                                        ?>
                                                        <li><?php
                                                            echo $Descripciones[$DetalleComponente->getId_descripcion()] . ": ";
                                                            if ($DetalleComponente->getValor() != NULL) {
                                                                echo $DetalleComponente->getValor();
                                                            } elseif ($DetalleComponente->getValor_alfanumerico() != NULL) {
                                                                echo $DetalleComponente->getValor_alfanumerico();
                                                            }
                                                            if ($DetalleComponente->getId_unidad_medida() != NULL) {
                                                                echo " " . $Unidades[$DetalleComponente->getId_unidad_medida()];
                                                            }
                                                            ?></li>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </lu>
                                            <?php
                                            print '</fieldset></div>';
                                        }
                                    }
                                }
                                $buscarComponente->free();
                            }
                            $TiposComponentes->free();
                            if ($banHayComponente === 0) {
                                print '<h5>No tiene componentes registrados</h5>';
                            }
                            ?>
                        </fieldset>

                        <form name="formulario" id="formulario" action="InicioReportes.php">
                            <button class="submit" name="Submit">Volver</button>
                        </form>
                    </div>
                </div>
                <?php include_once '../foot.php'; ?>
            </div>
        </div>
    </body>
</html>