
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sistema de Gestion de Incidentes de Software</title>
        <link rel="stylesheet" type="text/css" href="css/estilo.css" />
    </head>
    <body id="top">
        <?php
        session_start();
        include_once './limpiarSesion.php';
        //validamos si se ha hecho o no el inicio de sesion correctamente
        //si no se ha hecho la sesion nos regresará a login.php
        $permisos = array(1,2,3,4,5,6);
        $_SESSION['permisos'] = $permisos;
        include_once './master.php';
        include_once './verificarPermisos.php';
         ?>
        <div id="site">
            <div class="center-wrapper">
                <?php include_once './menu.php';?>
                <div class="main">
                    <div class="post">
                        <li class="no_lista"><h2>Bienvenido al Sistema de Gestion de Incidentes de Software</h2></li>
                        <br/>
                        <h3>Para comenzar seleccione una de las opciones del menu principal</h3>
                        <br/>
                        <br/>
                    </div>
                    <?php include './foot.php';?>
                </div>
            </div>
        </div>
    </body>
</html>
