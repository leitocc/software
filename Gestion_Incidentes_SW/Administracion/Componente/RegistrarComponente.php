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
        <script type="text/javascript" src="/Gestion_Incidentes_SW/js/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/Gestion_Incidentes_SW/js/jquery-ui.js"></script>
        <link rel="stylesheet" type="text/css" href="/Gestion_Incidentes_SW/css/estilo.css" />
        <script>
            $(document).ready(function() {
                $( "#anio" ).spinner();
                $("#volver").click(function(mievento){
                    mievento.preventDefault();
                    window.location = '/Gestion_Incidentes_SW/Administracion/PrincipalAdministracion.php';
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
                        /*$modo = filter_input(INPUT_GET, "modo");
                          $pagina = "Marca.php";
                        if($modo === "ins"){
                            $titulo = "Registrar Marca";
                            $marca = "";
                            $idMarca = "";
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
                        <form action="componente.php" method="post" name="formulario" class="contact_form">
                            <div>
                                <ul> 
                                    <li><h2>Registrar Componente</h2><span class="required_notification">Los campos con (*) son obligatorios</span></li>
                                    <li> <label>(*)Nombre:</label> 
                                        <input name="descripcion" id="descripcion" type="text">
                                    </li>
                                    <li> <label>(*)tipo componente</label>
                                           <select id="tipo_componente_software" name="tipo_componente_software"> 
                                               <option value="">Seleccione...</option>   
                                        <?php
                                           $query="select tc.idtipocomponente AS id, tc.descripcion from tipo_componente_software tc";
                                           $resultado100=$mysqli->query($query);
                                           if($resultado100){
                                              while ($row = $resultado100->fetch_assoc()) {
                                                ?>
                                                 <option value ="<?php echo $row['id'] ?>"><?php echo $row['descripcion'] ?></option>
                                            <?php
                                              }
                                           }
                                        ?>
                                        </select>         
                                    </li>
                                    <li>
                                        <label>( )Version</label>
                                        <input name="version" id="version" type="text"> 
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

