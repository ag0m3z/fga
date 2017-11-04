<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 11/06/2017
 * Time: 02:51 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";


$connect = new \core\seguridad();
$connect->valida_session_id();


if(
    array_key_exists('tipo_producto',$_POST)
){

    $TipoProducto = $_POST['tipo_producto'];

    if($TipoProducto == "ART"){

        $connect->_query = "SELECT opc_catalogo,nombre_catalogo FROM catalogo_general where idcatalogo = 1 AND idestado = 1;";

    }else if($TipoProducto == 'MAT'){
        $connect->_query = "SELECT idmateriales,nombre_material FROM materiales WHERE idestado = 1";
    }

    $connect->get_result_query();
    echo "<option value='0'>-- Seleccione el producto --</option>";
    for($i=0; $i < count($connect->_rows); $i++){
        echo "<option value='".$connect->_rows[$i][0]."'>".$connect->_rows[$i][1]."</option>";
    }

}else{
    echo "error";
}