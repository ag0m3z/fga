<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 09/10/2017
 * Time: 05:02 PM
 */
include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();
$connect->valida_session_id();

$idEmpresa = $_SESSION['data_home']['idempresa'];
$idUsuario = $_SESSION['data_login']['idusuario'];
$idDepartamento = $_SESSION['data_home']['iddepartamento'];
$FechaAcutal = date("Y-m-d H:i:s");

$Folio = $_POST['Folio'];
$Tipo = $_POST['Tipo'];

if($Tipo == 1){$Tipo =  "A";}else{$Tipo = "R";}

header("ContentType:application/json");

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(array_key_exists('Folio',$_POST) && array_key_exists('Tipo',$_POST) && array_key_exists('Motivo',$_POST)){

        $_POST = $connect->get_sanatiza($_POST);

        $connect->_query = "
        call sp_CancelarAportaciones('$Folio','$idEmpresa','$idDepartamento','$Tipo','$_POST[Motivo]','$idUsuario','$idUsuario')
        ";
        $connect->get_result_query();
        $Response = $connect->_rows[0][0];
        $FolioCancelacion = $connect->_rows[0][1];

        if($Response == "ok"){
            echo json_encode(array("result"=>true,"message"=>"Exito","data"=>array("Folio"=>$FolioCancelacion)));
        }else{
            echo json_encode(array("result"=>false,"message"=>$Response,"data"=>array()));
        }


    }else{
        echo json_encode(array("result"=>false,"message"=>"error en parametros","data"=>array()));
    }

}else{
    echo json_encode(array("result"=>false,"message"=>"Metodo no soportado","data"=>array()));
}