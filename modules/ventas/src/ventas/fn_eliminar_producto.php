<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 07/06/2017
 * Time: 10:50 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

include "../../controller/ClassControllerCarritoVentas.php";

header("Content-type:application/json");

$carrito = new ClassControllerCarritoVentas();

if(!array_key_exists('idproducto',$_POST)){
    echo json_encode(array("result"=>"error","mensaje"=>"Error la llave no existe"));
}else{
    if(!isset($_POST['idproducto'])){
        echo json_encode(array("result"=>"error","mensaje"=>"Error la llave no existe"));
    }else{

        $carrito->elimina_producto($_POST['idproducto']);
        echo json_encode(array("result"=>"ok"));
    }
}