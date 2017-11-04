<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 10/10/2017
 * Time: 06:02 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();
$connect->valida_session_id();

header("ContentType:application/json");

if($_SERVER['REQUEST_METHOD']=="GET"){

    $connect->_query = "call sp_GetMovimientosDiarios()";
    $connect->get_result_query(true);
    $Total=0;
    if(count($connect->_rows)>0){

        for($i=0;$i<count($connect->_rows);$i++){

            if($connect->_rows[$i]['idestatus'] == "A"){
                $Total += $connect->_rows[$i]['TotalPagado'];
            }else{
                $Total -= $connect->_rows[$i]['TotalPagado'];
            }

        }

        echo json_encode(array("result"=>true,"message"=>"Consulta exitosa","data"=>$connect->_rows,"Total"=>$Total));
    }else{
        echo json_encode(array("result"=>false,"message"=>"No se encontraron resultados","data"=>array()));
    }

}else{
    echo json_encode(array("result"=>false,"message"=>"Metodo no soportado","data"=>array()));
}