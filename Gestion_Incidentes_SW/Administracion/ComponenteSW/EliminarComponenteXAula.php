<?php
session_start();
$permisos = array("6", "1");
$_SESSION['permisos'] = $permisos;
include_once '../../verificarPermisos.php';
require_once '../../Conexion2.php';
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Componentes</title>
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/estilo.css" />
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/ajax.js"></script>
        <script type="text/javascript">

            window.onload = function () {
                document.getElementById("sala").onchange = function (e) {
                    var nrosala = document.getElementById('sala').value;
                    if (nrosala !== "") {
                        valida("/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/ComponenteSW/ajax/mostrarComponente2.php");
                    } else {
                        document.getElementById('componenteSoftware').innerHTML = "";
                    }
                };
                document.getElementById("volver").onclick = function (mievento) {
                    mievento.preventDefault();
                    location.href = '../PrincipalAdministracion.php';
                };
            };


            function procesaRespuesta() {
                if (peticion_http.readyState == READY_STATE_COMPLETE) {
                    if (peticion_http.status == 200) {
                        document.getElementById("componenteSoftware").innerHTML = peticion_http.responseText;
                    }
                }
            }
            function crea_query_string() {
                var idSala = document.getElementById("sala");
                return "idSala=" + encodeURIComponent(idSala.value) +
                        "&nocache=" + Math.random();
            }
        </script>
    </head>
    <body id="top">
        <?php include_once '../../master.php'; ?>
        <div id="site">
            <div class="center-wrapper">
                <?php include_once '../../menu.php'; ?>

                <div class="main">
                    <div class="post">
                        <form action="RegistrarEliminacionComponenteXAula.php" method="post" name="formulario" class="contact_form">
                            <li class="no_lista"><h2>Quitar Componente</h2></li>
                            <h4>Seleccionar aula</h4>
                            <div class="archive-separator"></div>
                            <?php
                            require_once '../../Conexion2.php';
                            print '<div><table><tr>';
                            print '<td>Seleccione un aula:</td>';
                            $query = "select * from sala";
                            $resultado = $mysqli->query($query);
                            print '<td><select name="sala" id="sala" required>';
                            print '<option value="" >Seleccione...</option>';
                            while ($row = $resultado->fetch_assoc()) {
                                print "<option value =\"" . $row['id_sala'] . "\" >";
                                print $row['nombre'] . "</option>";
                            }
                            print '</select></td>';
                            $resultado->free();
                            print '</tr></table></div>';
                            print '<div id="componenteSoftware"></div>';
                            print '<button class="submit" name="volver" id="volver">Volver</button><button class="submit" name="asignar" id="asignar">Eliminar</button>';
                            ?>
                        </form>
                    </div>
                </div>
                <?php include_once '../../foot.php'; ?>
            </div>
        </div>
    </body>
</html>

