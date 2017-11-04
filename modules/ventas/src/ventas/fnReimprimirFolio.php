<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 23/09/2017
 * Time: 08:47 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";


$connect = new \core\seguridad();

$connect->valida_session_id();

header("ContentType:application/json");

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $Folio = $_POST['folio'];

    $connect->_query= "SELECT idmovimiento,idventa,NoPago,Importe,TotalPagado,idestatus FROM movimientos_caja where idventa = $Folio ORDER BY FechaMovimiento desc";
    $connect->get_result_query();

    if(count($connect->_rows) > 0 ){

        for($i=0;$i<count($connect->_rows);$i++){

            if($connect->_rows[$i]['idestatus'] == "A"){
                $Saldo = ($Saldo + $connect->_rows[$i][4]);
            }
        }

        $Saldo = $connect->_rows[0][3] - $Saldo;

        echo json_encode(
            array(
                "result"=>true,
                "message"=>"consulta exitosa",
                "data"=>array(
                    "importe"=>$connect->_rows[0][3],
                    "saldo"=>$Saldo
                )
            )
        );

    }else{

        echo json_encode(
            array(
                "result"=>false,
                "message"=>"No se encontro el folio de venta",
                "data"=>array()
            )

        );

    }

}else{

    echo json_encode(
        array(
            "result"=>false,
            "message"=>"Metodo no soportado",
            "data"=>array()
        )
    );

}