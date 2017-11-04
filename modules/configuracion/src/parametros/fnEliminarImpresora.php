<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 16/09/2017
 * Time: 10:41 AM
 */


include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();
$idEmpresa = $_SESSION['data_home']['idempresa'];
$NoUsuario = $_SESSION['data_login']['idusuario'];

header("ContentType:applicatin/json");

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $_POST = $connect->get_sanatiza($_POST);
    $idImpresora = $_POST['idImpresora'];
    $idSucursal = $_POST['idSucursal'];

    if(empty($_POST['idImpresora']) == ""){


        $connect->_query = "UPDATE catalogo_general SET idestado = 0 where idcatalogo = 8 and idempresa = $idEmpresa and opc_catalogo = $idImpresora and opc_catalogo2 = $idSucursal and opc_catalogo3= 0 ";
        $connect->execute_query();
        echo json_encode(
            array(
                "result"=>true,
                "message"=>"Impresora eliminada correctamente",
                "data"=>array()
            )
        );


    }else{
        echo json_encode(
            array(
                "result"=>false,
                "message"=>"Parametros incorrectos o vacios",
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