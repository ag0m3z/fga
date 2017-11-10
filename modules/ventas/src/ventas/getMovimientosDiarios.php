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

            switch ($connect->_rows[$i]['TipoOperacion']){
                case 1:
                    $Total = $Total + $connect->_rows[$i]['TotalPagado'];
                    break;
                case 2:
                    $Total = $Total + $connect->_rows[$i]['TotalPagado'];
                    break;
                case 3:
                    $Total = $Total + $connect->_rows[$i]['TotalPagado'];
                    break;
                case 4:
                    $Total = $Total - $connect->_rows[$i]['TotalPagado'];
                    break;
                case 5:
                    $Total = $Total - $connect->_rows[$i]['TotalPagado'];
                    break;
            }

        }

        echo json_encode(array("result"=>true,"message"=>"Consulta exitosa","data"=>$connect->_rows,"Total"=>$Total));
    }else{
        echo json_encode(array("result"=>false,"message"=>"No se encontraron resultados","data"=>array()));
    }

}else{
    echo json_encode(array("result"=>false,"message"=>"Metodo no soportado","data"=>array()));
}