<?php
print 'hellow word';

session_start();
try {
    require_once '../../Conexion2.php';
    $modo = $_SESSION['modo'];
    print $modo;
    $idComponente = $_SESSION['idC'];
    if ($modo == "eli") {
        $consulta = "UPDATE componente SET baja=1, fecha_baja=Sysdate() "
                . "WHERE id_componente=" . $idComponente;
        $resultado = $mysqli->query($consulta);
        $resultado->free();
    } else {
        print 'entro ins';
        print '<br/>';
        $Sistema = $_SESSION['si'];
        $idTC = $_SESSION['idTC'];
        print $Sistema;
        print '<br/>';
        print $idTC;
        $modelo = filter_input(INPUT_POST, "modelo");
        $nroSerie = filter_input(INPUT_POST, "nroSerie");
        $nroPatrimonio = filter_input(INPUT_POST, "nroPatrimonio");
        $marca = filter_input(INPUT_POST, "marca");
        $mes = filter_input(INPUT_POST, "mes");
        $año = filter_input(INPUT_POST, "año");
        $proveedor = filter_input(INPUT_POST, "proveedor");
        //Ver el tema de subcomponente (se podria ignorar)
        if ($idTC > 4) {
            $idSubcomponente = $_SESSION['idSub'];
        } else {
            $idSubcomponente = "null";
        }

        
        //Aqui van los detalles
        $vectorDetalles[];
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

                $tamaño = filter_input(INPUT_POST, "tamaño");
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
                $tipo_memoria = filter_input(INPUT_POST, "tipo_memoria");
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
                $capacidad = filter_input(INPUT_POST, "capacidad");
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
                $tipoLectora = filter_input(INPUT_POST, "tipo_lectora");
                $detalle->__constructor();
                $detalle->setId_descripcion(8);
                $detalle->setValor(NULL);
                $detalle->setValor_alfanumerico($tipoLectora);
                $detalle->setId_unidad_medida(NULL);
                break;
            case 13:
                $cantNucleo = filter_input(INPUT_POST, "cantNucleo");
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
//        $velTransferencia = filter_input(INPUT_POST, "velTransferencia");
//        $capacidad = filter_input(INPUT_POST, "capacidad");
//        $conexion = filter_input(INPUT_POST, "conexion");
//        $tipo_memoria = filter_input(INPUT_POST, "tipo_memoria");
//        $tamaño = filter_input(INPUT_POST, "tamaño");
//        $cantNucleo = filter_input(INPUT_POST, "cantNucleo");
//        $velProcesamiento = filter_input(INPUT_POST, "velProcesamiento");
//        $tipo_lectora = filter_input(INPUT_POST, "tipo_lectora");
//        $mac = filter_input(INPUT_POST, "mac");
//        $potencia = filter_input(INPUT_POST, "potencia");
//        $frecuencia = filter_input(INPUT_POST, "frecuencia");

        print '<br/>Sistema: ' . $Sistema;
        print '<br/>modelo: ' . $modelo;
        print '<br/>nroSerie: ' . $nroSerie;
        print '<br/>mes: ' . $mes;
        print '<br/>año: ' . $año;
        print '<br/>provee: ' . $proveedor;
        print '<br/>idSub: ' . $idSubcomponente;
        print '<br/>';
        print_r($vectorDetalles);
        print '<br/>';

//        print '<br/>velTrans: ' . $velTransferencia;
//        print '<br/>cap: ' . $capacidad;
//        print '<br/>conex: ' . $conexion;
//        print '<br/>tipoMem: ' . $tipo_memoria;
//        print '<br/>tam: ' . $tamaño;
//        print '<br/>cantNucleo: ' . $cantNucleo;
//        print '<br/>velPros: ' . $velProcesamiento;
//        print '<br/>tipoLect: ' . $tipo_lectora;
//        print '<br/>mac: ' . $mac;
//        print '<br/>potenc: ' . $potencia;
//        print '<br/>frec: ' . $frecuencia;

        if ($modo === "ins") {
            $mysqli->autocommit(FALSE);
            $queryComponente = "Insert into componente "
                    . "(id_tipo_componente, "
                    . "descripcion, "
                    . "id_marca,"
                    . "anio_adquisicion, "
                    . "mes_adquisicion,"
                    . "id_proveedor,"
                    . "nro_patrimonio,"
                    . "nro_serie,"
                    . "id_sistema_informatico,"
                    . "baja,"
                    . "fecha_instalacion,"
                    . "id_subcomponente) values "
                    . "(" . $idTC . ",'"
                    . $modelo . "','"
                    . $marca . "',"
                    . $año . ","
                    . $mes . ","
                    . "null,'"
                    . $nroPatrimonio . "', '"
                    . $nroSerie . "','"
                    . $Sistema . "',"
                    . "0,"
                    . "Sysdate(),"
                    . $idSubcomponente . ")";
            echo $queryComponente . "<br/>";
            $resultado = $mysqli->query($queryComponente);
            if ($resultado) {
                $idComponente = $mysqli->insert_id;
                // Aqui se deben grabar los detalles
                #Detalle Potencia
                if ($vectorDetalles != NULL) {
                    foreach ($vectorDetalles as $detalle) {
                        $valor = "null";
                        $valorAlfa = "null";
                        if ($detalle->getValor() != "") {
                            $valor = $detalle->getValor();
                        }
                        if ($detalle->getValor_alfanumerico() != "") {
                            $valorAlfa = "'" . $detalle->getValor_alfanumerico() . "'";
                        }
                        $query = "INSERT INTO detalle_componente"
                                . "(id_componente,"
                                . "id_descipcion,"
                                . "valor,"
                                . "valor_alfanumerico,"
                                . "id_unidad_medida) values ("
                                . $idComponente . ", "
                                . $detalle->getId_descripcion() . ","
                                . $valor . ", "
                                . $valorAlfa . ", "
                                . $detalle->getId_unidad_medida() . ")";
                        echo $query . "</br>";
                        echo '<br/>';
                        if ($mysqli->query($query)) {
                            $mysqli->commit();
                            $msj = 1;
                        } else {
                            throw new Exception ();
                        }
                    }
                }
//                $insertDetalle = "INSERT INTO detalle_componente
//                            (`id_componente`,
//                            `id_descipcion`,
//                            `valor`,
//                            `valor_alfanumerico`,
//                            `id_unidad_medida`)
//                            VALUES
//                            (" . $idComponente . ", "
//                            . ",
//                            ,
//                            ,
//                            ,
//                            );";
//                
//                echo $insertDetalle . "<br/>";
            } else {
                throw new Exception ();
            }
        } elseif ($modo == "mod") {

            $consulta = "UPDATE componente SET descripcion='" . $modelo .
                    "' ,id_marca=" . $marca . " ,anio_adquisicion=" . $año .
                    " ,mes_adquisicion=" . $mes . ",nro_serie=" . $nroSerie .
                    ",nro_patrimonio=" . $nroPatrimonio .
                    " WHERE id_componente =" . $idComponente;

            $consulta = "UPDATE detalle_componente SET valor=" . $potencia . " where id_componente=" . $idComponente . " and id_descipcion=11";
            $mensaje = "Se actualizo correctamente el componente";
        }
    }
} catch (mysqli_sql_exception $myE) {
    print "Error al grabar en la BD: " . $myE;
    $msj = 2;
    $mysqli->rollback();
} catch (Exception $e) {
    print "Error general: " . $e;
    $msj = 2;
    $mysqli->rollback();
}
echo $mensaje;
//header('Location: /' . $_SESSION['RELATIVE_PATH'] . '/Administracion/PrincipalAdministracion.php?msj=' . $msj . '');
