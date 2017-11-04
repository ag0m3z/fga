<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 28/10/2017
 * Time: 12:10 AM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();
$connect->valida_session_id();

header("ContentType:application/json");

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(array_key_exists('idcompra',$_POST)){

        //Todo correcto
        $_POST = $connect->get_sanatiza($_POST);
        $idDetalleCompra = $_POST['idarticulo'];

        $connect->_query = "DELETE FROM detalle_compra WHERE iddetalle_compra = $idDetalleCompra ";
        $connect->execute_query();

        echo json_encode(
            array(
                "result"=>true,
                "message"=>"Parametros Correctos",
                "data"=>$_POST
            )
        );

    }else{
        echo json_encode(
            array(
                "result"=>false,
                "message"=>"Parametros incorrectos",
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