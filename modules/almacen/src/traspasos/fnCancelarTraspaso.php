<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 28/09/2017
 * Time: 08:20 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();
$connect->valida_session_id();

$idEmpresa = $_SESSION['data_home']['idempresa'];
$NoUsuario = $_SESSION['data_login']['idusuario'];

header("ContentType:application/json");

if($_SERVER['REQUEST_METHOD']=="POST"){

    if(isset($_POST['idTraspaso'])){

        $idTraspaso = $_POST['idTraspaso'];

        $connect->_query = "
        call sp_CancelarTraspaso('$idTraspaso','$NoUsuario');
        ";
        $connect->get_result_query();
        $Mensaje =$connect->_rows[0][0];

        if($Mensaje == 'ok'){

            echo json_encode(array("result"=>true, "message"=>"Traspaso exitoso","data"=>array($Mensaje)));

        }else{
            echo json_encode(array("result"=>false, "message"=>"Error el traspaso ya no se encuentra pendiente","data"=>array($Mensaje)));
        }

    }else{
        echo json_encode(array("result"=>false, "message"=>"Parametros incorrectos","data"=>array()));
    }

}else{
    echo json_encode(array("result"=>false, "message"=>"Metodo no soportado","data"=>array()));
}