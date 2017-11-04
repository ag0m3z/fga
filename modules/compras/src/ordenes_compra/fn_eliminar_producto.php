<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 08/06/2017
 * Time: 12:27 AM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

include "../../controllers/ControllerCart.php";

$connect = new \core\seguridad();
$connect->valida_session_id();
$carrito = new ControllerCart();

header("Content-type:application/json");

if(array_key_exists('idproducto',$_POST)){
    if(isset($_POST['idproducto'])){
        $carrito->elimina_producto($_POST['idproducto']);
        echo json_encode(array("result"=>"ok"));
    }
}