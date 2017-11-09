<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 10/06/2017
 * Time: 11:49 PM
 */


include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../controller/ClassControllerVentas.php";

$connect = new ClassControllerVentas();
$connect->valida_session_id();

header("Content-type:application/json");

if(
    array_key_exists('folio_venta',$_POST) &&
    array_key_exists('importe_pendiente',$_POST) &&
    array_key_exists('importe_pago',$_POST) &&
    array_key_exists('importe_total',$_POST) &&
    !empty($_POST['folio_venta']) &&
    !empty($_POST['importe_pendiente']) &&
    !empty($_POST['importe_pago']) &&
    !empty($_POST['importe_total'])
){

    $FolioVenta = $_POST['folio_venta'];
    $ImportePendiente = $_POST['importe_pendiente'];
    $ImportePagado = $_POST['importe_pago'];
    $ImporteTotal = $_POST['importe_total'];
    $TipoVenta = $_POST['tipo_venta'];
    $FechaActual = date("y-m-d H:i:s");
    $NoUsuarioAlta = $_SESSION['data_login']['idusuario'];

    //Abono o Liquidacion
    if($ImportePagado >= $ImportePendiente){
        // Liquidacion
        $ImpPagado = $ImportePendiente;
        $ImpRecivido = $ImportePagado;
        $TipoTicket= "liquidacion";
        $Cambio = ($ImportePagado - $ImportePendiente);
    }else{
        //Abono a deuda
        $ImpPagado = $ImportePagado;
        $ImpRecivido = $ImportePagado;
        $TipoTicket= "abono";
        $Cambio = "0";
    }

    //Movimientos Caja
    $connect->_query = "call sp_registra_movimientos_caja(
    '$TipoVenta','2',
    '$FolioVenta',
    '$ImporteTotal',
    '$NoUsuarioAlta',
    'A',
    '$ImpPagado',
    '$ImpRecivido',
    '1',
    '0',
    '0',
    '0',
    '$FechaActual'
    )";

    $connect->get_result_query();
    $FolioPago = $connect->_rows[0][0];

    echo json_encode(array("result"=>"ok","mensaje"=>"success","data"=>array("folio_venta"=>$FolioVenta,"tipo_ticket"=>$TipoTicket,"folio_pago"=>$connect->getFormatFolio($FolioPago,4),"cambio"=>$Cambio)));

}else{
    echo json_encode(array("result"=>"error","mensaje"=>"Error no se encntraron los parametros","data"=>array()));
}
