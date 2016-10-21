<?php
session_start();
$permisos = array("6", "1");
$_SESSION['permisos'] = $permisos;
include_once '../verificarPermisos.php';
include_once '../limpiarSesion.php';
require_once '../Conexion2.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Componentes</title>
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/estilo.css" />
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/ajax.js"></script>
        <script type="text/javascript">
            function crea_query_string() {
                var idTipoComponente = document.getElementById("tipoComponente");
                return "idTipoComponente=" + encodeURIComponent(idTipoComponente.value) +
                        "&nocache=" + Math.random();
            }

            function procesaRespuesta() {
                if (peticion_http.readyState == READY_STATE_COMPLETE) {
                    if (peticion_http.status == 200) {
                        document.getElementById("datos").innerHTML = peticion_http.responseText;
                        document.getElementById("buscar").setAttribute("hidden", true);
                        var tipo = document.getElementById("tipoComponente");
                        var valor = tipo.options[tipo.selectedIndex].text;
                        var h4 = document.getElementsByTagName("h4");
                        h4[0].innerHTML = "Tipo componente: " + valor;
                    }
                }
            }
 
            function volver(mievento) {
                mievento.preventDefault();
                location.assign('PrincipalSistemaInformatico.php');
            }

            window.onload = function () {
                document.getElementById("siguiente").onclick = function (mievento) {
                    mievento.preventDefault();
                    if (document.getElementById("tipoComponente").value !== "") {
                        valida("/<?php echo $_SESSION['RELATIVE_PATH'] ?>/SistemaInformatico/ajax/nuevoComponente.php");
                    } else {
                        alert("Ingrese un tipo de componente");
                    }
                };
                document.getElementById("volver").onclick = volver;
            };

        </script>
    </head>
    <body id="top">
        <?php include_once '../master.php'; ?>
        <div id="site">
            <div class="center-wrapper">
                <?php include_once '../menu.php'; ?>

                <div class="main">
                    <div class="post">
                        <form action="AsignarComponente.php" method="post" name="formulario" class="contact_form">
                            <li class="no_lista"><h2>Registrar nuevo componente general</h2></li>
                            <h4>Tipo de componente</h4>
                            <div class="archive-separator"></div>
                            <div style="width: 800px" id="buscar">
                                <div style="width: 400px">
                                    <table>
                                        <tr>
                                            <td>Tipo de componente</td>
                                            <td>
                                                <?php
                                                $query = "select * from tipo_componente";
                                                $resultado = $mysqli->query($query);
                                                $aux = "<select name='tipoComponente' id='tipoComponente' required>";
                                                $aux.= "<option value=''>Seleccione...</option>";
                                                print($aux);
                                                while ($row = $resultado->fetch_assoc()) {
                                                    $aux = "<option value =" . $row['id_tipo_componente'] . " >";
                                                    $aux.= $row['descripcion'] . "</option>";
                                                    print($aux);
                                                    $aux = "";
                                                }
                                                print '</select>';
                                                $resultado->free();
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <table>
                                    <tr>
                                        <td colspan="2">
                                            <button name="siguiente" id="siguiente" class="submit">Siguiente</button>
                                            <button name="volver" id="volver" class="submit">Volver</button>
                                        </td>
                                    </tr>
                                </table>    
                            </div>
                            <div style="width: 600px" id="datos"></div>
                        </form>
                    </div>
                </div>
                <?php include_once '../foot.php'; ?>
            </div>
        </div>
    </body>
</html>
