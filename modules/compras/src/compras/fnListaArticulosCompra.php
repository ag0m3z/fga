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

        $idCompra = $_POST['idcompra'];
        $idDetalleCompra = $_POST['idarticulo'];

        $connect->_query = "
        select 
          d.iddetalle_compra,
          e.codigo,
          d.cantidad,
          e.nombre_articulo,
          d.tipo_articulo,
          d.precio_compra
        from detalle_compra as d
        left join articulos as e 
        on d.idarticulo = e.idarticulo
        where d.idcompra = $idCompra
        ";
        $connect->get_result_query(true);

        echo json_encode(
            array(
                "result"=>true,
                "message"=>"Parametros Correctos",
                "data"=>$connect->_rows
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