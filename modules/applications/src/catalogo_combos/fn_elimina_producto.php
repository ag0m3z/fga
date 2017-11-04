<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 11/06/2017
 * Time: 03:49 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";

include "../../controllers/ClassControllerCartCombos.php";

$carrito = new ClassControllerCartCombos();


header("Content-type:application:json");


$carrito->elimina_producto($_POST['id']);

echo json_encode(array("result"=>"success","mensaje"=>"producto eliminado correctamente","data"=>array()));