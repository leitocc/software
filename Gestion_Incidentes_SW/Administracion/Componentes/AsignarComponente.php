<?php
session_start();
$permisos = array("6", "1");
$_SESSION['permisos'] = $permisos;
include_once '../../verificarPermisos.php';
require_once '../../Conexion2.php';
include_once '../../limpiarSesion.php';
require_once '../../DetalleComponente.class.php';

//Falta crear una variable en la sesion que guarde los atributos del componente(marca, modelo....)
require_once '../../Componente.class.php';

$marca = filter_input(INPUT_POST, "marca");
$modelo = filter_input(INPUT_POST, "modelo");
$mes = filter_input(INPUT_POST, "mes");
$anio = filter_input(INPUT_POST, "anio");
$proveedor = filter_input(INPUT_POST, "proveedor");
$idTipoComponente = filter_input(INPUT_POST, "tipoComponente");
$Contenido = array("marca" => $marca, "idTipoComponente" => $idTipoComponente, "modelo" => $modelo, "mes" => $mes, "anio" => $anio, "proveedor" => $proveedor, "");
$_SESSION["Componente"] = $Contenido;


$_SESSION['Detalles'] = NULL;

$vectorDetalles = new ArrayObject();
$detalle = new DetalleComponente();
switch ($idTipoComponente) {
    case 1:
        $conexion = filter_input(INPUT_POST, "conexion");
        $detalle->__constructor();
        $detalle->setId_descripcion(3);
        $detalle->setValor(NULL);
        $detalle->setValor_alfanumerico($conexion);
        $detalle->setId_unidad_medida(NULL);
        $vectorDetalles[] = $detalle;

        $medida = filter_input(INPUT_POST, "medida");
        $detalle->__constructor();
        $detalle->setId_descripcion(5);
        $detalle->setValor($medida);
        $detalle->setValor_alfanumerico(NULL);
        $detalle->setId_unidad_medida(7);
        $vectorDetalles[] = $detalle;
        break;
    case 2:
        $conexion = filter_input(INPUT_POST, "conexion");
        $detalle->__constructor();
        $detalle->setId_descripcion(3);
        $detalle->setValor(NULL);
        $detalle->setValor_alfanumerico($conexion);
        $detalle->setId_unidad_medida(NULL);
        $vectorDetalles[] = $detalle;
        break;
    case 3:
        $conexion = filter_input(INPUT_POST, "conexion");
        $detalle->__constructor();
        $detalle->setId_descripcion(3);
        $detalle->setValor(NULL);
        $detalle->setValor_alfanumerico($conexion);
        $detalle->setId_unidad_medida(NULL);
        $vectorDetalles[] = $detalle;
        break;
    case 5:
        $tipoMemoria = filter_input(INPUT_POST, "tipoMemoria");
        $detalle->__constructor();
        $detalle->setId_descripcion(4);
        $detalle->setValor(NULL);
        $detalle->setValor_alfanumerico($tipoMemoria);
        $detalle->setId_unidad_medida(NULL);
        $vectorDetalles[] = $detalle;

        $capacidad = filter_input(INPUT_POST, "capacidad");
        $detalle->__constructor();
        $detalle->setId_descripcion(2);
        $detalle->setValor(capacidad);
        $detalle->setValor_alfanumerico(null);
        $detalle->setId_unidad_medida(3);
        $vectorDetalles[] = $detalle;

        $frecuencia = filter_input(INPUT_POST, "frecuencia");
        $detalle->__constructor();
        $detalle->setId_descripcion(12);
        $detalle->setValor($frecuencia);
        $detalle->setValor_alfanumerico(null);
        $detalle->setId_unidad_medida(1);
        $vectorDetalles[] = $detalle;
        break;
    //discoDuro
    case 6:
        $conexion = filter_input(INPUT_POST, "conexion");
        $detalle->__constructor();
        $detalle->setId_descripcion(3);
        $detalle->setValor(NULL);
        $detalle->setValor_alfanumerico($conexion);
        $detalle->setId_unidad_medida(NULL);
        $vectorDetalles[] = $detalle;

        $velocidadTransferencia = filter_input(INPUT_POST, "velTransferencia");
        $detalle->__constructor();
        $detalle->setId_descripcion(1);
        $detalle->setValor($velocidadTransferencia);
        $detalle->setValor_alfanumerico(NULL);
        $detalle->setId_unidad_medida(8);
        $vectorDetalles[] = $detalle;
        
        $capacidad = filter_input(INPUT_POST, "capacidad");
        $detalle->__constructor();
        $detalle->setId_descripcion(2);
        $detalle->setValor(capacidad);
        $detalle->setValor_alfanumerico(null);
        $detalle->setId_unidad_medida(3);
        $vectorDetalles[] = $detalle;
        break;
    case 8:
        $capacidadMemoria = filter_input(INPUT_POST, "capacidadMemoria");
        $detalle->__constructor();
        $detalle->setId_descripcion(2);
        $detalle->setValor($capacidadMemoria);
        $detalle->setValor_alfanumerico(NULL);
        $detalle->setId_unidad_medida(4);
        break;
    case 9:
        $mac = filter_input(INPUT_POST, "mac");
        $detalle->__constructor();
        $detalle->setId_descripcion(10);
        $detalle->setValor(NULL);
        $detalle->setValor_alfanumerico($mac);
        $detalle->setId_unidad_medida(NULL);
        break;
    case 11:
        $tipoLectora = filter_input(INPUT_POST, "tipoLectora");
        $detalle->__constructor();
        $detalle->setId_descripcion(8);
        $detalle->setValor(NULL);
        $detalle->setValor_alfanumerico($tipoLectora);
        $detalle->setId_unidad_medida(NULL);
        break;
    case 13:
        $cantidadNucleo = filter_input(INPUT_POST, "cantNucleo");
        $detalle->__constructor();
        $detalle->setId_descripcion(6);
        $detalle->setValor($cantidadNucleo);
        $detalle->setValor_alfanumerico(NULL);
        $detalle->setId_unidad_medida(NULL);

        $velocidadProcesamiento = filter_input(INPUT_POST, "velocidad");
        $detalle->__constructor();
        $detalle->setId_descripcion(7);
        $detalle->setValor($velocidadProcesamiento);
        $detalle->setValor_alfanumerico(NULL);
        $detalle->setId_unidad_medida(2);
        break;
    case 14:
        $potencia = filter_input(INPUT_POST, "potencia");
        $detalle->__constructor();
        $detalle->setId_descripcion(10);
        $detalle->setValor($potencia);
        $detalle->setValor_alfanumerico(NULL);
        $detalle->setId_unidad_medida(10);
        break;

    default:
        break;
}

$_SESSION['Detalles'] = $vectorDetalles;
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Componentes</title>
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/estilo.css" />
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/ajax.js"></script>
        <script type="text/javascript">
            function procesaRespuesta() {
                if (peticion_http.readyState == READY_STATE_COMPLETE) {
                    if (peticion_http.status == 200) {
                        document.getElementById("sistemaInformatico").innerHTML = peticion_http.responseText;
                        //document.getElementById("asignar").removeAttribute('disabled');
                    }
                }
            }
            function crea_query_string() {
                var idSala = document.getElementById("sala");
                return "idSala=" + encodeURIComponent(idSala.value) +
                        "&nocache=" + Math.random();
            }
            function siTodos() {
                var todos = document.getElementById("todos");
                var lista = document.getElementById("lista");
                var si = lista.getElementsByTagName("input");
                var item;
                for(var x=0;x<si.length;x++) 
                {
                    item = si[x];
                    if(todos.checked){
                        item.setAttribute('checked', true);
                    }else{
                        item.removeAttribute('checked');
                    }
                }
            }
            window.onload = function () {
                document.getElementById("sala").onchange = function (e) {
                    var nrosala = document.getElementById("sala").value;
                    if (nrosala !== "") {
                        var url2 = "/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/ajax/mostrarSala.php";
                        valida(url2);
                    } else {
                        document.getElementById('sistemaInformatico').innerHTML = "";
                        //document.getElementById("asignar").setAttribute('disabled', true);
                    }
                };
                document.getElementById("volver").onclick = function (mievento) {
                    mievento.preventDefault();
                    location.href = "../PrincipalAdministracion.php";
                };
            };
        </script>
    </head>
    <body id="top">
        <?php include_once '../../master.php'; ?>
        <div id="site">
            <div class="center-wrapper">
                <?php include_once '../../menu.php'; ?>

                <div class="main">
                    <div class="post">
                        <form action="registrarNuevoCG.php" method="post" name="formulario" class="contact_form">
                            <li class="no_lista"><h2>Asignar componente general</h2></li>
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
                            print '<div id="sistemaInformatico"></div>';
                            print '<button class="submit" name="volver" id="volver">Cancelar</button><button class="submit" name="asignar" id="asignar">Asignar</button>';
                            ?>
                        </form>
                    </div>
                </div>
                <?php include_once '../../foot.php'; ?>
            </div>
        </div>
    </body>
</html>
