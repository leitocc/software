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
        <title>Sistema de Gestion de Incidentes</title>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery-ui.js"></script>
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/estilo.css" />
        <script>
            $(document).ready(function () {
                $("#volver").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/PrincipalAdministracion.php';
                });
                $("#componenteSoftware").change(function (e) {
                    if ($("#componenteSoftware").val() !== "") {
                        $.ajax({
                            url: "/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/ComponenteSW/ajax/cargarComponenteSW.php",
                            type: "POST",
                            data: "id=" + $("#componenteSoftware").val(),
                            success: function (opciones) {
                                $("#datosComponente").html(opciones).show("slow");
                            }
                        });
                    } else {
                        $("#datosComponente").html();
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
                        <form action="componenteModificar.php" method="post" name="formulario" class="contact_form">
                            <div>
                                <ul> 
                                    <li><h2>Modificar Componente</h2><span class="required_notification"></span></li>                                  
                                    <li> <label>Selecionar componente</label>
                                        <select id="componenteSoftware" name="componenteSoftware"> 
                                            <option value="">Seleccione...</option>   
                                            <?php
                                            $query = "select ts.idComponente_software AS id, CONCAT(ts.descripcion,' ',IFNULL(ts.version,' ')) as descripcionTotal from componente_software ts";
                                            $resultado100 = $mysqli->query($query);
                                            if ($resultado100) {
                                                while ($row = $resultado100->fetch_assoc()) {
                                                    ?>
                                                    <option value ="<?php echo $row['id'] ?>"><?php echo $row['descripcionTotal'] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>         
                                    </li>
                                    <div id="datosComponente"> <!--  Aqui hay que cargar los datos atomaticamente para ser modificados */-->
                                    </div>

                                    <li> 
                                        <button class="submit" type="submit" id="volver">Volver</button>
                                        <button class="submit" type="submit">Modificar</button>
                                    </li> 
                                </ul>                                
                            </div>
                        </form>
                    </div>
                </div>
                <?php include_once '../../foot.php'; ?>
            </div>
        </div>
    </body>
</html>


