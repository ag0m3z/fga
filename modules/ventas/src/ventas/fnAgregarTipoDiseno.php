<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 16/09/2017
 * Time: 01:34 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();

header("ContentType:application/json");


if($_SERVER["REQUEST_METHOD"] == "POST"){

    $idTipoDiseno = $_POST['idDiseno'];

    $connect->_query = "SELECT nombre_catalogo,moneda1 FROM catalogo_general where idcatalogo = 7 AND opc_catalogo = $idTipoDiseno AND idestado = 1";
    $connect->get_result_query();

    $NombreDiseno = $connect->_rows[0][0];
    $PrecioDiseno = $connect->_rows[0][1];


    $_SESSION['cart_costo_trabajo']['nombre'] = $NombreDiseno;
    $_SESSION['cart_costo_trabajo']['precio']= $PrecioDiseno;

    echo json_encode(array("result"=>true,"message"=>"Costo Agregado Correctamente","data"=>array()));


    
}else{
    echo json_encode(array("result"=>false,"message"=>"Metodo no soportado","data"=>array()));
}
