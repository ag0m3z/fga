<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 10/10/2017
 * Time: 03:08 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();
$connect->valida_session_id();

header("ContentType:application/json");

if($_SERVER['REQUEST_METHOD'] == "POST"){



}else{

    echo json_encode(array("result"=>false,"message"=>"Metodo no soportado","data"=>array()));

}