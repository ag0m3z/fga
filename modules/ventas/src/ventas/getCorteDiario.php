<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 09/10/2017
 * Time: 10:48 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();
$connect->valida_session_id();

$idUsuario = $_SESSION['data_login']['idusuario'];
$idEmpresa = $_SESSION['data_home']['idempresa'];
$idPerfil = $_SESSION['data_login']['idperfil'];

$idDepartamento = $_SESSION['data_home']['iddepartamento'];
$FechaInicial = date("Y-m-d H:i:s");
$FechaFinal = date("Y-m-d H:i:s");

header("ContentType:application/json");

if($_SERVER['REQUEST_METHOD'] == "GET"){

    //Movimientos Caja (Pagos y Notas)
    $connect->_query = "
    call sp_CorteDiario(2,'$idEmpresa','$idDepartamento','$FechaInicial','$FechaFinal');
    ";
    $connect->get_result_query();
    $Movimientos = array(
        "Notas"=>$connect->_rows[0][0],
        "Pagos"=>$connect->_rows[0][1],
        "Cancelaciones"=>$connect->_rows[0][2],
        "Total"=>($connect->_rows[0][0] + $connect->_rows[0][1] ) - $connect->_rows[0][2]
    );


    //Movimientos de Aportaciones y Salidas
    $connect->_query = "
    call sp_CorteDiario(1,'$idEmpresa','$idDepartamento','$FechaInicial','$FechaFinal');
    ";
    $connect->get_result_query();
    $data =array(
        "Entradas"=>array(
            "Entradas"=>$connect->_rows[0][0],
            "Salidas"=>$connect->_rows[0][1],
            "Cancelacion"=>$connect->_rows[0][2],
            "Total"=>($connect->_rows[0][0] - $connect->_rows[0][1] ) - $connect->_rows[0][2]
        ),
        "Aportaciones"=>array(
            "Aportacion"=>$connect->_rows[0][3],
            "Retiro"=>$connect->_rows[0][4],
            "Cancelacion"=>$connect->_rows[0][5],
            "Total"=>($connect->_rows[0][3] - $connect->_rows[0][4] ) - $connect->_rows[0][5]
        ),
        "Movimientos"=>$Movimientos
    );

    echo json_encode(array("result"=>true,"message"=>"Consulta Exitosa","data"=>$data));
}else{
    echo json_encode(array("result"=>false,"message"=>"Metodo no soportado","data"=>array()));
}