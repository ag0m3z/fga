<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 30/09/2017
 * Time: 12:29 AM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();
header("ContentType:application/json");

$idUsuario = $_SESSION['data_login']['idusuario'];
$idEmpresa = $_SESSION['data_home']['idempresa'];
$NoDepartamento = $_SESSION['data_home']['iddepartamento'];

if($_SERVER['REQUEST_METHOD'] == "GET") {

    if (!isset($_POST['FechaActual'])) {

        $FechaActual = $_GET['FechaActual'];

        $fecha = date('Y-m-j');
        $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
        $FechaMenos1  = date ( 'Y-m-j' , $nuevafecha );


        $connect->_query = "SELECT MAX(date(fecha_cierre)) FROM cierre where idempresa = $idEmpresa AND iddepartamento = $NoDepartamento ";
        $connect->get_result_query();

        $FechaUltimoCierre = $connect->_rows[0][0];

        if ($connect->_rows[0][0] == NULL) {
            //No hay registros en la Tabla de cierre
            echo json_encode(array("result" => true, "message" => "Sistema Nuevo, Realizae la Apertura de la caja", "data" => array("opc"=>1)));
        } else {

            if ($FechaUltimoCierre == $FechaActual) {
                echo json_encode(array("result" => true, "message" => "El cierre ya se encuentra realizado", "data" => array("opc"=>2,"FechaCierre" => $FechaUltimoCierre)));
            }

            if ($FechaUltimoCierre < $FechaMenos1) {
                //No se ha realizado el cierre
                echo json_encode(array("result" => true, "message" => "No se ha realizado el cierre", "data" => array("opc"=>3,"FechaCierre" => $FechaUltimoCierre )));
            }else{
                echo json_encode(array("result" => true, "message" => "No se ha realizado el cierre", "data" => array("opc"=>3,"FechaCierre" => $FechaUltimoCierre )));
            }
        }
    }else {
        echo json_encode(array("result" => false, "message" => "Parametros incorrectos", "data" => array()));
    }
}else{

    echo json_encode(array("result"=>false,"message"=>"Metodo no soportado","data"=>array()));
}