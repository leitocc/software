<?php
session_start();
$permisos = array("6", "1");
$_SESSION['permisos'] = $permisos;
include_once '../verificarPermisos.php';
require_once '../Conexion.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sistemas Informaticos - Alta</title>
        <script type="text/javascript" src="/IncidentesSoftware/js/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/IncidentesSoftware/js/jquery-ui.js"></script>
        <link rel="stylesheet" type="text/css" href="/IncidentesSoftware/css/estilo.css" />
        <script type="text/javascript">
            $(document).ready(function() {
                $("#volver").click(function(mievento){
                    mievento.preventDefault();
                    //history.back();
                    window.location = 'PrincipalSistemaInformatico.php';
                });
            });
        </script>
    </head>
    <body id="top">
        <?php include_once '../master.php';?>
        <div id="site">
            <div class="center-wrapper">
                <?php include_once '../menu.php';?>
                <form action="SistemaInformatico.php" method="Post" name="formulario" id="formulario" class="contact_form">
                <div> 
                   <ul> 
                       <li> <h2>Nuevo Sistema Informático</h2> <span class="required_notification">Los campos con (*) son obligatorios</span> </li> 
                       <li> <label for="id">ID m&aacute;quina:</label> <input name="id" type="text" placeholder="ID maquina" required/> </li>
                       <li> <label for="sala">Sala:</label> <?php $consulta = mysql_query("select * from sala"); ?>
                           <select name="sala" required>
                          <option value="">Seleccione...</option>
                          <?php while ($row = mysql_fetch_array($consulta)) { ?>
                          <option value ="<?php echo $row['id_sala'] ?>"><?php echo $row['nombre'] ?></option>
                          <?php } ?>
                       </select> </li> 
                       <li> <button class="submit" type="submit" id="volver">Volver</button>
                            <button class="submit" type="submit">Guardar</button> </li> 
                   </ul> 
               </div>
              </form>
            </div>
        </div>
    </body>
</html>
