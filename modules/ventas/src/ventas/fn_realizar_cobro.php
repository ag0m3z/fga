<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 05/06/2017
 * Time: 01:07 PM
 */
/**
 * Incluir las Librerias Principales del Sistema
 * En el Siguiente Orden ruta de libreias: @@/SistemaIntegral/core/
 *
 * 1.- core.php;
 * 2.- sesiones.php
 * 3.- seguridad.php o modelo ( ej: model_aparatos.php)
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";
include "../../controller/ClassControllerCarritoVentas.php";

/**
 * 1.- Instanciar la Clase seguridad y pasar como valor la BD del Usuario
 * 2.- Llamar al metodo @@valida_session_id($NoUsuario), para validar que el usuario este conectado y con una sesión valida
 *
 * Ejemplo:
 * Si se requiere cambiar de servidor de base de datos
 * $data_server = array(
 *   'bdHost'=>'192.168.2.5',
 *   'bdUser'=>'sa',
 *   'bdPass'=>'pasword',
 *   'port'=>'3306',
 *   'bdData'=>'dataBase'
 *);
 *
 * Si no es requerdio se puede dejar en null
 *
 * con @data_server
 * @@$seguridad = new \core\seguridad($_SESSION['data_login']['BDDatos'],$data_server);
 *
 * Sin @data_server
 * @@$seguridad = new \core\seguridad($_SESSION['data_login']['BDDatos']);
 *
 * @@$seguridad->valida_session_id($_SESSION['data_login']['NoUsuario']);
 */

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
$connect = new \core\seguridad();
$connect->valida_session_id();

$carrito = new ClassControllerCarritoVentas();
header("ContentType:application/json");

if($_SERVER['REQUEST_METHOD'] == "POST"){

    //Validar parametros
    if(
        array_key_exists('tipo_venta',$_POST) &&
        array_key_exists('tipo_pago',$_POST) &&
        array_key_exists('total_venta',$_POST) &&
        array_key_exists('pago_inicial',$_POST) &&
        array_key_exists('pago_efectivo',$_POST) &&
        array_key_exists('pago_tarjeta',$_POST) &&
        array_key_exists('FechaEntrega',$_POST)
    ){

        //Sanatizar Datos
        $_POST = $connect->get_sanatiza($_POST);

        $idEmpresa = $_SESSION['data_home']['idempresa'];
        $idDepartamento = $_SESSION['data_home']['iddepartamento'];
        $idAlmacen = $_SESSION['data_home']['almacen'];
        $NoUsuarioAlta = $_SESSION['data_login']['idusuario'];

        $idCliente = $_POST['idcliente'];
        $DescripcionGeneral = $_POST['descripcion_general'];
        $TipoVenta = $_POST['tipo_venta'];
        $TipoPago = $_POST['tipo_pago'];
        $TotalVenta = $_POST['total_venta'];
        $PagoInicial = $_POST['pago_inicial'];
        $PagoEfectivo = $_POST['pago_efectivo'];
        $PagoTarjeta = $_POST['pago_tarjeta'];

        //Convertir la Fecha y Hora de entrega en Formato DateTime
        $FechaEntrega = $_POST['FechaEntrega'];
        $HoraEntrega = $_POST['HoraEntrega'];
        $MinutoEntrega = $_POST['MinutoEntrega'];
        $FormatoEntrega = $_POST['FormatoEntrega'];

        $CadenaHora = $HoraEntrega.":".$MinutoEntrega.$FormatoEntrega;
        $CadenaHora = strtotime($CadenaHora);
        $HoraEntrega = date("H:i:s", $CadenaHora);

        $FechaEntrega = $FechaEntrega." ".$HoraEntrega;


        $FechaActual = date("Y-m-d H:i:s");
        $Cambio = (($PagoEfectivo + $PagoTarjeta) - $TotalVenta);

        //Registrar en ventas
        $connect->_query = "call sp_registra_venta('$idEmpresa','$idDepartamento','$NoUsuarioAlta','$idCliente','$TipoVenta','$DescripcionGeneral',1,'$FechaActual','$FechaEntrega')";
        $connect->get_result_query();
        $idVenta = $connect->_rows[0][0];

        $listaCarrito = $carrito->imprime_carrito();
        $Existencias = 0;

        switch ($TipoVenta){
            case 1://venta de contado

                if($PagoEfectivo < $TotalVenta){
                    echo json_encode(array('result'=>false,"message"=>"El pago es inferior al total de la venta","data"=>array()));

                }else{
                    //Registrar en detalle_venta
                    for($i=0;$i < count($listaCarrito);$i++){

                        $TipoArticulo = $listaCarrito[$i]['tipo_producto'];
                        $idArticulo = $listaCarrito[$i]['idproducto'];
                        $Cantidad = $listaCarrito[$i]['cantidad'];
                        $PrecioCompra = $listaCarrito[$i]['precio_venta'];
                        $Descripcion = $listaCarrito[$i]['descripcion'];
                        $CostoTrabajoCP = $listaCarrito[$i]['TipoDiseno'];

                        //$Existencias = $Existencias + $listaCarrito[$i]['existencias'];
                        $listaCarrito[$i]['existencias'] = ($listaCarrito[$i]['existencias'] - $Cantidad);

                        if($listaCarrito[$i]['existencias'] <= 0){
                            $Existencias++;
                        }

                        $connect->_query = "call sp_registra_detalle_venta(
                        '$idEmpresa',
                        '$idAlmacen',
                        '$idVenta',
                        '$TipoArticulo',
                        '$idArticulo',
                        '$Cantidad',
                        '$PrecioCompra',
                        '$CostoTrabajoCP',
                        '$Descripcion'                  
                        )";
                        $connect->execute_query();
                    }

                    //Movimientos Caja
                    $connect->_query = "call sp_registra_movimientos_caja(
                    '1','1',
                    '$idVenta',
                    '$TotalVenta',
                    '$NoUsuarioAlta',
                    'A',
                    '$TotalVenta',
                    '$PagoEfectivo',
                    '$TipoPago',
                    '0',
                    '$PagoTarjeta',
                    '',
                    '$FechaActual'
                    )";
                    $connect->execute_query();
                }

                $FolioVenta = $connect->getFormatFolio($idVenta,4);
                echo json_encode(array('result'=>true,"message"=>"Venta registrado correctamente","data"=>array("FolioVenta"=>$FolioVenta,"cambio"=>$Cambio,"existencias"=>$Existencias,"articulos"=>$listaCarrito)));

                break;
            case 2://venta de credito

                if($PagoEfectivo < $PagoInicial){
                    echo json_encode(array('result'=>false,"message"=>"El pago minimo debe ser de : $PagoInicial","data"=>array()));
                }else{

                    //Registrar en detalle_venta
                    for($i=0;$i < count($listaCarrito);$i++){

                        $TipoArticulo = $listaCarrito[$i]['tipo_producto'];
                        $idArticulo = $listaCarrito[$i]['idproducto'];
                        $Cantidad = $listaCarrito[$i]['cantidad'];
                        $PrecioCompra = $listaCarrito[$i]['precio_venta'];
                        $Descripcion = $listaCarrito[$i]['descripcion'];
                        $CostoTrabajoCP = $listaCarrito[$i]['TipoDiseno'];

                        //$Existencias = $Existencias + $listaCarrito[$i]['existencias'];

                        $listaCarrito[$i]['existencias'] = ($listaCarrito[$i]['existencias'] - $Cantidad);

                        if($listaCarrito[$i]['existencias'] <= 0){
                            $Existencias++;
                        }

                        $connect->_query = "call sp_registra_detalle_venta(
                        '$idEmpresa',
                        '$idAlmacen',
                        '$idVenta',
                        '$TipoArticulo',
                        '$idArticulo',
                        '$Cantidad',
                        '$PrecioCompra',
                        '$CostoTrabajoCP',
                        '$Descripcion'
                        )";
                        $connect->execute_query();
                    }

                    if($PagoEfectivo >= $TotalVenta){
                        $ImportePagado = $TotalVenta;
                    }else{

                        $ImportePagado = $PagoEfectivo;

                    }

                    //Movimientos Caja
                    $connect->_query = "call sp_registra_movimientos_caja(
                    '2','1',
                    '$idVenta',
                    '$TotalVenta',
                    '$NoUsuarioAlta',
                    'A',
                    '$ImportePagado',
                    '$PagoEfectivo',
                    '$TipoPago',
                    '0',
                    '$PagoTarjeta',
                    '',
                    '$FechaActual'
                    )";
                    $connect->execute_query();
                }

                $FolioVenta = $connect->getFormatFolio($idVenta,4);
                echo json_encode(array('result'=>true,"message"=>"Venta registrado correctamente","data"=>array("FolioVenta"=>$FolioVenta,"cambio"=>"","existencias"=>$Existencias,"articulos"=>$listaCarrito)));

                break;
            default:
                echo json_encode(array('result'=>false,"message"=>"No se encontraron los parametros, para realizar el proceso de venta","data"=>array()));
                break;
        }

    }else{

        echo json_encode(array('result'=>false,"message"=>"No se encontraron los parametros, para realizar el proceso de venta","data"=>array()));

    }


}else{
    echo json_encode(array("result"=>false,"message"=>"Metodo no soportado","data"=>array()));
}

//$('.currency').numeric({prefix:'$ ', cents: true});
