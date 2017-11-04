<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 11/06/2017
 * Time: 03:56 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

include "../../controllers/ClassControllerCartCombos.php";

$carrito = new ClassControllerCartCombos();
$connect = new \core\seguridad();
$connect->valida_session_id();

header("Content-type:application/json");


$dataListProduct = $carrito->imprime_carrito();

if(count($dataListProduct) > 0 ){


    if(
        array_key_exists('codigo_combo',$_POST) &&
        array_key_exists('nombre_combo',$_POST) &&
        !empty($_POST['codigo_combo']) &&
        !empty($_POST['nombre_combo'])
    ){

        $_POST = $connect->get_sanatiza($_POST);
        $CodigoCombo = $_POST['codigo_combo'];
        $NombreCombo = $_POST['nombre_combo'];
        $Descripcion = $_POST['descripcion'];

        $FechaAlta = date("y-m-d H:i:s");
        $NoUsuarioAlta = $_SESSION['data_login']['idusuario'];

        $connect->_query = "call sp_registra_combo(
        '1',
        '0',
        '$CodigoCombo',
        '$NombreCombo',
        '$Descripcion',
        '$NoUsuarioAlta',
        '$FechaAlta'
        )";

        $connect->get_result_query();
        $idCombo = $connect->_rows[0][0];

        for($i=0;$i <count($dataListProduct);$i++){

            $idProducto = $dataListProduct[$i]['idproducto'];
            $TipoProducto = $dataListProduct[$i]['tipo_producto'];

            $connect->_query = "call sp_registra_detalle_combo(
            '$idCombo',
            '$idProducto',
            '$TipoProducto'
            )";

            $connect->execute_query();
        }

        echo json_encode(
            array(
                "result"=>"success",
                "mensaje"=>"Combo registrado correctamente",
                "data"=>array("idcombo"=>$idCombo)
            )
        );

    }else{
        echo json_encode(
            array(
                "result"=>"error",
                "mensaje"=>"Error no se encontraron las llaves para el resgistro del combo",
                "data"=>array()
            )
        );
    }

}else{
    echo json_encode(
        array(
            "result"=>"error",
            "mensaje"=>"Error no se encontraron productos para registrar el combo",
            "data"=>array()
        )
    );
}

