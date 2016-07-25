<?php if (isset($_SESSION['usuario'])) { ?>
    <div id="header">
        <div class="clearer">&nbsp;</div>
        <div id="site-title">
            <div class="mit_t"> .: Laboratorio de Sistemas :. </div>
        </div>
        <div class="navigation">
            <div class="main-nav">
                <ul class="tabbed">
                    <li class="current-tab"><a href="/Gestion_Incidentes_SW/index.php"><span>Inicio</span></a></li>
                    <li><a href="/Gestion_Incidentes_SW/SistemaInformatico/PrincipalSistemaInformatico.php"><span>Sistemas Informáticos</span></a></li>
                    <li><a href="/Gestion_Incidentes_SW/Incidentes/InicioIncidentes.php"><span>Incidentes</span></a></li>
                   <!-- <li><a href="/Gestion_Incidenes_SW/Reportes/InicioReportes.php"><span>Reportes</span></a></li>-->
                    <li><a href="/Gestion_Incidentes_SW/Administracion/PrincipalAdministracion.php"><span>Administración</span></a></li>
                </ul>
                <div class="clearer">&nbsp;</div>
            </div>
        </div>
    </div>
    <?php
}?>