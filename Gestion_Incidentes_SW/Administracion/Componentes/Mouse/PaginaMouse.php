<?php
session_start();
$permisos = array("6", "1");
$_SESSION['permisos'] = $permisos;
include_once '../../../verificarPermisos.php';
require_once '../../../Conexion.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sistema de Gestion de Incidentes</title>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery-ui.js"></script>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery.validate.js"></script>
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/estilo.css" />
        <?php
        if ($_REQUEST['modo'] == "ins") {
            $titulo = "Registrar Mouse";
            $pagina = "Mouse.php?modo=ins";
            $id = null;
            $marca = "";
            $mes = "";
            $anio = 2000;
            $patrimonio = "";
            $serie = "";
            $descripcion = "";
            $tipoCon = "";
        } else {
            $consulta = mysql_query("SELECT c.id_componente as id ,c.descripcion as modelo, c.id_marca AS marca, c.nro_patrimonio as patrimonio, c.nro_serie as serie, c.anio_adquisicion as anio, c.mes_adquisicion as mes FROM componente c where c.id_sistema_informatico =" . $_SESSION['si'] . " and c.id_tipo_componente = 2 AND c.baja=0 ");
            if (mysql_num_rows($consulta) == 0) {
                $id = null;
                $marca = "";
                $mes = "";
                $anio = 2000;
                $patrimonio = "";
                $serie = "";
                $descripcion = "";
                $tipoCon = "";
            } else {
                $titulo = "Modificar Mouse ";
                $pagina = "Mouse.php?modo=mod";
                while ($row = mysql_fetch_array($consulta)) {
                    $id = $row['id'];
                    $marca = $row['marca'];
                    if (empty($row['mes'])) {
                        $mes = "Ninguno";
                    } else {
                        $mes = $row['mes'];
                    }
                    if (empty($row['anio'])) {
                        $anio = 2000;
                    } else {
                        $anio = $row['anio'];
                    }

                    if (empty($row['patrimonio'])) {
                        $patrimonio = "";
                    } else {
                        $patrimonio = $row['patrimonio'];
                    }

                    if (empty($row['serie'])) {
                        $serie = "";
                    } else {
                        $serie = $row['serie'];
                    }

                    if (empty($row['modelo'])) {
                        $descripcion = "";
                    } else {
                        $descripcion = $row['modelo'];
                    }
                }

                $consulta3 = mysql_query("SELECT  D.valor_alfanumerico as valor FROM detalle_componente D inner join componente C on (D.id_componente=C.id_componente) where C.id_sistema_informatico = " . $_SESSION['si'] . " and D.id_descipcion = 3 and C.baja=0 and C.id_tipo_componente=2");
                if (mysql_num_rows($consulta3) == 0) {
                    $tipoCon = "";
                } else {
                    while ($row = mysql_fetch_array($consulta3)) {
                        $tipoCon = $row['valor'];
                    }
                }
            }
        }
        ?>
        <script>
            $(document).ready(function () {
                $("#anio").spinner();
                $("#NroInventario").attr("disabled", true);
                if ($("#NroInventario").val() !== "") {
                    $("#NroInventario").attr("disabled", false);
                    $("#invSI").attr("checked", true);
                } else {
                    $("#invNO").attr("checked", true);
                }
                $("#invSI").click(function () {
                    $("#NroInventario").attr("disabled", false);
                });
                $("#invNO").click(function () {
                    $("#NroInventario").attr("disabled", true);
                });
                $("#Volver").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/ModificarComponentesSI.php';
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

                        <form action="<?php echo $pagina ?>" method="post" name="formulario" id="formulario" class="contact_form">
                            <li><h2><?php echo $titulo ?></h2><span class="required_notification">Los campos con (*) son obligatorios</span></li>
                            <div style="width: 600px;">
                                <table>
                                    <tr>
                                        <td> Sistema Informatico</td>
                                        <td><input name="SI" type="text" maxlength="20" readonly="true" value="<?php echo $_SESSION['si'] ?>"/>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Marca (*)</td>
                                        <td>
                                                <?php $consulta = mysql_query("select * from marca"); ?>
                                            <select name='marca' id="marca" required>
                                                <option value="" >Seleccione...</option>
                                                        <?php while ($row = mysql_fetch_array($consulta)) { ?>
                                                    <option value ="<?php echo $row['id_marca']; ?>" <?php if ($row['id_marca'] == $marca) {
                                                            echo 'selected="true"';
                                                        }
                                                        ?>> <?php echo $row['descripcion'] ?> </option>
<?php } ?>
                                            </select>
                                        </td>
                                    </tr> 

                                    <tr>
                                        <td> Modelo (*)</td>
                                        <td><input name="modelo" id="modelo" type="text" maxlength="20" value="<?php echo $descripcion ?>" required></td>
                                    </tr>

                                    <tr>
                                        <td>Numero de serie</td>
                                        <td><input name="nroSerie" id="nroSerie" type="text" size="50" maxlength="100" value="<?php echo $serie ?>"></td>
                                    </tr>




                                    <tr>
                                        <td>Mes de adquisicion </td>
                                        <td>  
                                            <select name="mes" id="mes" required>
                                                <option value="" >Seleccione...</option>
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
                                        <td>Año adquisicion</td>
                                        <td><input id="anio" name="año" value="<?php echo $anio ?>" required></td>
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


                                    <tr>
                                        <td>¿Esta inventariado?</td>
                                        <td>    
                                            <input type="radio" name="inventariado" id="invNO" value="no"> No
<?php
if ($patrimonio != "") {
    ?>
                                                <input type="radio" name="inventariado" id="invSI" value="si" checked="true"> Si
<?php } else { ?>
                                                <input type="radio" name="inventariado" id="invSI" value="si"> Si
<?php } ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Numero de inventario</td>
                                        <td><div name="inv"><input type="text" name="NroInventario" id="NroInventario" value="<?php echo $patrimonio ?>"></div></td>
                                    </tr>

                                    <tr>
                                    <tr>
                                        <td>Tipo de conexion (*)</td>
                                        <td> 
<?php $consulta = mysql_query("select * from tipo_conexion"); ?>
                                            <select name='conexion' id="conexion" required>
                                                <option value="" >Seleccione...</option>
<?php while ($row = mysql_fetch_array($consulta)) { ?>
                                                    <option value ="<?php echo $row['nombre']; ?>" <?php if ($row['nombre'] == strtoupper($tipoCon)) {
        echo 'selected="true"';
    }
    ?> ><?php echo $row['nombre'] ?> </option>
                                                    }
<?php } ?>
                                            </select>
                                        </td>  
                                    </tr>
                                </table>
                            </div>
                            <li>
                                <button class="submit" name="volver" id="Volver">Volver</button>
                                <button class="submit" title="Registrar">Registrar</button>
                            </li>
                        </form>
                    </div>
                </div>
<?php include_once '../../../foot.php'; ?>
            </div>
        </div>
    </body>
</html>