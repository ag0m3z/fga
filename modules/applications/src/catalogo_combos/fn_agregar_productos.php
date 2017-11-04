<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 11/06/2017
 * Time: 03:05 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";

include "../../controllers/ClassControllerCartCombos.php";

$carrito = new ClassControllerCartCombos();


header("Content-type:application/json");

if(
    array_key_exists('idproducto',$_POST) &&
    array_key_exists('tipo_producto',$_POST) &&
    array_key_exists('nombre_producto',$_POST)

){

$carrito->introduce_producto($_POST['idproducto'],$_POST['nombre_producto'],$_POST['tipo_producto']);

echo json_encode(
    array(
        "result"=>"success",
        "mensaje"=>"Producto agregado correctamente",
        "data"=>array(

        )
    )
);


}else{
    echo json_encode(
        array(
            "result"=>"error",
            "mensaje"=>"No se encontraron las llaves para agregar el producto al combo",
            "data"=>array()
        )
    );
}