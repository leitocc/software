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
                $("#anio").spinner();
                $("#volver").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/PrincipalAdministracion.php';
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
                        <?php
                        $modo = filter_input(INPUT_GET, "modo");
                        $pagina = "Marca.php";
                        if ($modo === "ins") {
                            $titulo = "Registrar Marca";
                            $marca = "";
                            $idMarca = "";
                        } elseif ($modo === "mod") {
                            $titulo = "Modificar Marca";
                            $idMarca = filter_input(INPUT_POST, "marca");
                            $query24 = "select descripcion from marca where id_marca = " . $idMarca;
                            $consulta = $mysqli->query($query24);
                            while ($row = $consulta->fetch_assoc()) {
                                $marca = $row['descripcion'];
                            }
                        }
                        //echo "modo: ".$modo."<br/>pagina: ".$pagina."<br/>marca: ".$marca."<br/>idMarca: ".$idMarca;
                        ?>
                        <form action="<?php echo $pagina ?>" method="post" name="formulario" class="contact_form">
                            <div>
                                <ul> 
                                    <li><h2><?php echo $titulo ?></h2><span class="required_notification">Los campos con (*) son obligatorios</span></li>
                                    <li> <label for="nombre">(*)Nombre:</label> 
                                        <input name="nombre" type="text" value="<?php echo $marca ?>" required>
                                    </li>
                                    <li> 
                                        <button class="submit" type="submit" id="volver">Volver</button>
                                        <button class="submit" type="submit">Guardar</button> 
                                    </li> 
                                </ul>
                                <input type="hidden" name="idMarca" value="<?php echo $idMarca ?>"/>
                                <input type="hidden" name="modo" value="<?php echo $modo ?>"/>
                            </div>
                        </form>
                    </div>
                </div>
                <?php include_once '../../foot.php'; ?>
            </div>
        </div>
    </body>
</html>
