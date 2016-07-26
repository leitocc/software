<?php
session_start();
$permisos = array("6", "1");
$_SESSION['permisos'] = $permisos;
include_once '../../verificarPermisos.php';
require_once '../../Conexion2.php';?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sistema de Gestion de Incidentes</title>
        <script type="text/javascript" src="/IncidentesSoftware/js/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/IncidentesSoftware/js/jquery-ui.js"></script>
        <link rel="stylesheet" type="text/css" href="/IncidentesSoftware/css/estilo.css" />
        <script>
            $(document).ready(function() {
                $( "#anio" ).spinner();
                $("#volver").click(function(mievento){
                    mievento.preventDefault();
                    window.location = '/IncidentesSoftware/Administracion/PrincipalAdministracion.php';
                });
            });
        </script>
    </head>

    <body id="top">
        <?php include_once '../../master.php';?>
        <div id="site">
            <div class="center-wrapper">
                <?php include_once '../../menu.php';?>
                <div class="main">
                    <div class="post">
                        <?php
                        /*
                        }elseif($modo === "mod"){
                            $titulo = "Modificar Marca";
                            $idMarca = filter_input(INPUT_POST, "marca");
                            $query24="select descripcion from marca where id_marca = ".$idMarca;
                            $consulta = $mysqli->query($query24);
                            while ($row = $consulta->fetch_assoc()) {
                                $marca = $row['descripcion'];
                            } 
                        }*/
                        
                        //echo "modo: ".$modo."<br/>pagina: ".$pagina."<br/>marca: ".$marca."<br/>idMarca: ".$idMarca;
                        ?>
                        <form action="componenteBaja.php" method="post" name="formulario" class="contact_form">
                            <div>
                                <ul> 
                                    <li><h2>Eliminar Componente</h2><span class="required_notification"></span></li>                                  
                                    <li> <label>componente</label>
                                           <select id="componenteSoftware" name="componenteSoftware"> 
                                               <option value="">Seleccione...</option>   
                                        <?php
                                           $query="select ts.idComponente_software AS id, CONCAT(ts.descripcion,' ',IFNULL(ts.version,' ')) as descripcionTotal from componente_software ts";
                                           $resultado100=$mysqli->query($query);
                                           if($resultado100){
                                              while ($row = $resultado100->fetch_assoc()) {
                                                ?>
                                                 <option value ="<?php echo $row['id'] ?>"><?php echo $row['descripcionTotal'] ?></option>
                                            <?php
                                              }
                                           }
                                        ?>
                                        </select>         
                                    </li>
                                    <li> <button class="submit" type="submit">Guardar</button> <button class="submit" type="submit" id="volver">Volver</button></li> 
                                </ul>                                
                            </div>
                        </form>
                    </div>
                </div>
                <?php include_once '../../foot.php';?>
            </div>
        </div>
    </body>
</html>


