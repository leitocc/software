<?php
session_start();
$permisos = array("6", "1");
$_SESSION['permisos'] = $permisos;
include_once '../../verificarPermisos.php';
if (isset($_REQUEST['idIncidente'])) {
    $_SESSION['idIncidente'] = $_REQUEST['idIncidente'];
}
if (isset($_REQUEST['si'])) {
    $_SESSION['si'] = $_REQUEST['si'];
}
$SI = $_SESSION['si'];
require_once '../../Conexion2.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sistemas Informaticos - Componentes HW</title>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery-ui.js"></script>
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/estilo.css" />
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/tabla.css" />
        <script>
            $(document).ready(function () {
                $("#volver").click(function (mievento) {
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/ModificarSisitemaInformatico.php';
                });
                $("#agregarNuevo").click(function (mievento) {
                    var TC = $("#nvoComponente").val();
                    if (TC !== "") {
                        window.location = 'ComponenteHW.php?idSI=<?php echo $SI ?>&idTC=' + TC + '&mod=ins';
                    }
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
                        <li class="no_lista"><h2>Componentes del Sistema Informático <?php echo $SI ?></h2></li>
                        <li class="no_lista">
                            <?php
                            $msj = filter_input(INPUT_GET, "msj");
                            if (isset($msj)) {
                                switch ($msj) {
                                    case 1:
                                        echo '<div class="msj_ok">Se grabó correctamente</div>';
                                        break;
                                    case 2:
                                        echo '<div class="msj_error">Se produjo un error al grabar</div>';
                                        break;
                                    case 3:
                                        echo '<div class="msj_ok">Se realizaron los cambios correctamente</div>';
                                        break;
                                    default:
                                        break;
                                }
                            }
                            echo '<table class="listado">
                                <caption>Componentes Externos</caption>
                                <thead>
                                    <tr>
                                        <th>
                                            Tipo Componente
                                        </th>
                                        <th>
                                            Marca - Patrimonio/Serie/Modelo
                                        </th>
                                        <th>
                                            Acci&oacute;n
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>';

                            //Monitor-----------
                            $consulta = "SELECT C.id_componente, TC.descripcion AS 'tipo_componente', C.descripcion, 
                                C.nro_patrimonio, C.nro_serie, M.descripcion AS 'marca'
                                FROM componente C 
                                INNER JOIN marca M on (M.id_marca=C.id_marca)
                                INNER JOIN tipo_componente TC ON C.id_tipo_componente = TC.id_tipo_componente
                                WHERE C.id_tipo_componente = 1 and C.baja = 0
                                AND C.id_sistema_informatico = " . $SI;
                            $resultado = $mysqli->query($consulta);
                            if (!$resultado || $resultado->num_rows === 0) {
                                $descripcion = "No asignado";
                                $nuevo = true;
                            } else {
                                $nuevo = false;
                                while ($row = $resultado->fetch_assoc()) {
                                    $descripcion = $row['marca'];
                                    if ($row['nro_patrimonio'] != "" && $row['nro_patrimonio'] != null) {
                                        $descripcion .= " - Patrimonio: " . $row['nro_patrimonio'];
                                    } elseif ($row['nro_serie'] != "" && $row['nro_serie'] != null) {
                                        $descripcion .= " - Serie:" . $row['nro_serie'];
                                    } elseif ($row['descripcion'] != "" && $row['descripcion'] != null) {
                                        $descripcion .= " - Modelo:" . $row['descripcion'];
                                    }
                                    break;
                                }
                            }
                            print ' <tr>
                                        <td>
                                            Monitor
                                        </td>
                                        <td>
                                            ' . $descripcion . '
                                        </td>
                                        <td>';
                            if ($nuevo) {
                                print '<a href="ComponenteHW.php?idSI=' . $SI . '&idTC=1&mod=ins">Agregar</a>';
                            } else {
                                print '<a href="ComponenteHW.php?idC=' . $row['id_componente'] . '&mod=mod">Modificar</a>&nbsp;&nbsp;';
                                print '<a href="QuitarComponenteHW.php">Quitar</a>';
                            }
                            print '     </td>
                                    </tr>';

                            //Mouse--------------------------
                            $consulta = "SELECT C.id_componente, TC.descripcion AS 'tipo_componente', C.descripcion, 
                                C.nro_patrimonio, C.nro_serie, M.descripcion AS 'marca'
                                FROM componente C 
                                INNER JOIN marca M on (M.id_marca=C.id_marca)
                                INNER JOIN tipo_componente TC ON C.id_tipo_componente = TC.id_tipo_componente
                                WHERE C.id_tipo_componente = 2 and C.baja = 0
                                AND C.id_sistema_informatico = " . $SI;
                            $resultado = $mysqli->query($consulta);
                            if (!$resultado || $resultado->num_rows === 0) {
                                $descripcion = "No asignado";
                                $nuevo = true;
                            } else {
                                $nuevo = false;
                                while ($row = $resultado->fetch_assoc()) {
                                    $descripcion = $row['marca'];
                                    if ($row['nro_patrimonio'] != "" && $row['nro_patrimonio'] != null) {
                                        $descripcion .= " - Patrimonio: " . $row['nro_patrimonio'];
                                    } elseif ($row['nro_serie'] != "" && $row['nro_serie'] != null) {
                                        $descripcion .= " - Serie:" . $row['nro_serie'];
                                    } elseif ($row['descripcion'] != "" && $row['descripcion'] != null) {
                                        $descripcion .= " - Modelo:" . $row['descripcion'];
                                    }
                                    break;
                                }
                            }
                            print ' <tr>
                                        <td>
                                            Mouse
                                        </td>
                                        <td>
                                            ' . $descripcion . '
                                        </td>
                                        <td>';
                            if ($nuevo) {
                                print '<a href="ComponenteHW.php?idSI=' . $SI . '&idTC=2&mod=ins">Agregar</a>';
                            } else {
                                print '<a href="ComponenteHW.php?idC=' . $row['id_componente'] . '&mod=mod">Modificar</a>&nbsp;&nbsp;';
                                print '<a href="QuitarComponenteHW.php?idC=' . $row['id_componente'] . '&mod=eli">Quitar</a>';
                            }
                            print '     </td>
                                    </tr>';


                            //Teclado--------------------------
                            $consulta = "SELECT C.id_componente, TC.descripcion AS 'tipo_componente', C.descripcion, 
                                C.nro_patrimonio, C.nro_serie, M.descripcion AS 'marca'
                                FROM componente C 
                                INNER JOIN marca M on (M.id_marca=C.id_marca)
                                INNER JOIN tipo_componente TC ON C.id_tipo_componente = TC.id_tipo_componente
                                WHERE C.id_tipo_componente = 3 and C.baja = 0
                                AND C.id_sistema_informatico = " . $SI;
                            $resultado = $mysqli->query($consulta);
                            if (!$resultado || $resultado->num_rows === 0) {
                                $descripcion = "No asignado";
                                $nuevo = true;
                            } else {
                                $nuevo = false;
                                while ($row = $resultado->fetch_assoc()) {
                                    $descripcion = $row['marca'];
                                    if ($row['nro_patrimonio'] != "" && $row['nro_patrimonio'] != null) {
                                        $descripcion .= " - Patrimonio: " . $row['nro_patrimonio'];
                                    } elseif ($row['nro_serie'] != "" && $row['nro_serie'] != null) {
                                        $descripcion .= " - Serie:" . $row['nro_serie'];
                                    } elseif ($row['descripcion'] != "" && $row['descripcion'] != null) {
                                        $descripcion .= " - Modelo:" . $row['descripcion'];
                                    }
                                    break;
                                }
                            }
                            print ' <tr>
                                        <td>
                                            Teclado
                                        </td>
                                        <td>
                                            ' . $descripcion . '
                                        </td>
                                        <td>';
                            if ($nuevo) {
                                print '<a href="ComponenteHW.php?idSI=' . $SI . '&idTC=3&mod=ins">Agregar</a>';
                            } else {
                                print '<a href="ComponenteHW.php?idC=' . $row['id_componente'] . '&mod=mod">Modificar</a>&nbsp;&nbsp;';
                                print '<a href="QuitarComponenteHW.php?idC=' . $row['id_componente'] . '&mod=eli">Quitar</a>';
                            }
                            print '     </td>
                                    </tr>';

                            //CPU--------------------------
                            $consulta = "SELECT C.id_componente, TC.descripcion AS 'tipo_componente', C.descripcion, 
                                C.nro_patrimonio, C.nro_serie, M.descripcion AS 'marca'
                                FROM componente C 
                                INNER JOIN marca M on (M.id_marca=C.id_marca)
                                INNER JOIN tipo_componente TC ON C.id_tipo_componente = TC.id_tipo_componente
                                WHERE C.id_tipo_componente = 4 and C.baja = 0
                                AND C.id_sistema_informatico = " . $SI;
                            $resultado = $mysqli->query($consulta);
                            if (!$resultado || $resultado->num_rows === 0) {
                                $descripcion = "No asignado";
                                $nuevo = true;
                            } else {
                                $nuevo = false;
                                while ($row = $resultado->fetch_assoc()) {
                                    $descripcion = $row['marca'];
                                    if ($row['nro_patrimonio'] != "" && $row['nro_patrimonio'] != null) {
                                        $descripcion .= " - Patrimonio: " . $row['nro_patrimonio'];
                                    } elseif ($row['nro_serie'] != "" && $row['nro_serie'] != null) {
                                        $descripcion .= " - Serie:" . $row['nro_serie'];
                                    } elseif ($row['descripcion'] != "" && $row['descripcion'] != null) {
                                        $descripcion .= " - Modelo:" . $row['descripcion'];
                                    }
                                    break;
                                }
                            }
                            print ' <tr>
                                        <td>
                                            CPU
                                        </td>
                                        <td>
                                            ' . $descripcion . '
                                        </td>
                                        <td>';
                            if ($nuevo) {
                                print '<a href="ComponenteHW.php?idSI=' . $SI . '&idTC=4&mod=ins">Agregar</a>';
                            } else {
                                print '<a href="ComponenteHW.php?idC=' . $row['id_componente'] . '&mod=mod">Modificar</a>&nbsp;&nbsp;';
                                print '<a href="QuitarComponenteHW.php?idC=' . $row['id_componente'] . '&mod=eli">Quitar</a>';
                            }
                            print '     </td>
                                    </tr>';
                            $resultado->free();

                            print '</tbody>
                            </table>';
                            ?>
                        </li>
                        <li class="no_lista">
                            <?php
                            echo '<table class="listado">
                                <caption>Componentes Internos</caption>
                                <thead>
                                    <tr>
                                        <th>
                                            Tipo Componente
                                        </th>
                                        <th>
                                            Marca - Patrimonio/Serie/Modelo
                                        </th>
                                        <th>
                                            Acci&oacute;n
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>';

                            //Componentes Internos--------------------------
                            $consulta = "SELECT C.id_componente, TC.descripcion AS 'tipo_componente', C.descripcion, 
                                C.nro_patrimonio, C.nro_serie, M.descripcion AS 'marca', TC.id_tipo_componente
                                FROM componente C 
                                INNER JOIN marca M on (M.id_marca=C.id_marca)
                                INNER JOIN tipo_componente TC ON C.id_tipo_componente = TC.id_tipo_componente
                                WHERE C.id_tipo_componente > 4 and C.baja = 0
                                AND C.id_sistema_informatico = " . $SI
                                    . " ORDER BY TC.descripcion";
                            $resultado = $mysqli->query($consulta);
                            if ($resultado && $resultado->num_rows > 0) {
                                while ($row = $resultado->fetch_assoc()) {
                                    $tipoComponente = $row['tipo_componente'];
                                    $descripcion = $row['marca'];
                                    if ($row['nro_patrimonio'] != "" && $row['nro_patrimonio'] != null) {
                                        $descripcion .= " - Patrimonio: " . $row['nro_patrimonio'];
                                    } elseif ($row['nro_serie'] != "" && $row['nro_serie'] != null) {
                                        $descripcion .= " - Serie:" . $row['nro_serie'];
                                    } elseif ($row['descripcion'] != "" && $row['descripcion'] != null) {
                                        $descripcion .= " - Modelo:" . $row['descripcion'];
                                    }
                                    print ' <tr>
                                                <td>
                                                    ' . $tipoComponente . '
                                                </td>
                                                <td>
                                                    ' . $descripcion . '
                                                </td>
                                                <td>';
                                    print '<a href="ComponenteHW.php?idC=' . $row['id_componente'] . '&mod=mod">Modificar</a>&nbsp;&nbsp;';
                                    print '<a href="QuitarComponenteHW.php?idC=' . $row['id_componente'] . '&mod=eli">Quitar</a>';
                                    print '     </td>
                                            </tr>';
                                }
                            }
                            print '</tr>';
                            print '</tbody>
                            </table>';
                            ?>
                            <h4>Agregar nuevo componente interno</h4>
                        <li class="no_lista">
                            Seleccionar tipo componente:
                            <select name="nvoComponente" id="nvoComponente">
                                <option value="">Seleccione...</option>
                                <?php
                                $query = "SELECT * FROM gestion_incidentes.tipo_componente
                                            WHERE id_tipo_componente > 4";
                                $resultado = $mysqli->query($query);
                                if ($resultado) {
                                    while ($row = $resultado->fetch_assoc()) {
                                        echo '<option value="' . $row['id_tipo_componente'] . '">' . $row['descripcion'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                            <button class="submit" type="submit" id="agregarNuevo">-></button>
                        </li>
                        <li class="no_lista">
                            <button class="submit" type="submit" id="volver">Volver</button>
                        </li> 
                    </div>
                </div>
                <?php include_once '../../foot.php'; ?>
            </div>
        </div>
    </body>
</html>