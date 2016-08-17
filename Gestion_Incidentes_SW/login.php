<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
    <head>
        <meta http-equiv="Cache-Control" content="no-cache" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <meta name="description" content="Universidad Tecnológica Nacional - Facultad Regional Córdoba - Departamento Ingeniería en Sistemas de Información .: Laboratorio de Sistemas :." />
        <meta name="keywords" content="Laboratorio de Sistemas, labsis, Congresos, Investigación, Biblioteca LabSis" />
        <meta name="author" content="" />
        <link rel="stylesheet" type="text/css" href="css/estilo.css" media="screen" />
        <title>.: Departamento de Sistemas - LabSis - Sistema de Gestion de Incidentes de Software :.</title>
    </head>

    <body id="top">
        <?php
        include_once './master.php';
        ?>

        <div id="site">
            <div class="center-wrapper">

                <div id="header">
                    <div class="clearer">&nbsp;</div>
                    <div id="counter"></div>
                    <div id="site-title">
                        <div class="mit_t"> .: Laboratorio de Sistemas :. </div>
                    </div>
                    <div class="navigation">
                        <div class="main-nav">
                            <ul class="tabbed">
                            </ul>
                            <div class="clearer">&nbsp;</div>
                        </div>
                    </div>
                </div>

                <div class="main">
                    <div class="post">
                        <h2>Bienvenido al Sistema de Gestion de Incidentes de Software</h2>
                        <div class="left" id="main-content">
                            <div id="respond">
                                <ul>
                                    <li>
                                        <div class="comment-profile-wrapper left">
                                            <div class="comment-profile">
                                            </div>
                                        </div>
                                        <div class="comment-content-wrapper">
                                            <div class="comment-body">
                                                <div class="comment-arrow"></div>
                                                Bienvenido a sistema de registro de Incidentes en equipos informaticos.<br />
                                                Totalmente administrable y de fácil uso.
                                                <br /><br /><br />
                                                Necesita logearse para poder tener acceso al sistema.<br /><br />
                                            </div>
                                        </div>
                                        <div class="clearer">&nbsp;</div>
                                    </li>
                                </ul>
                                <div class="clearer">&nbsp;</div><div class="archive-separator"></div>
                            </div>
                        </div>
                        <div class="clearer">&nbsp;</div>
                    </div>
                    <div class="clearer">&nbsp;</div>
                </div>

                <?php include_once './foot.php'; ?>
            </div>
        </div>
    </body>
</html>