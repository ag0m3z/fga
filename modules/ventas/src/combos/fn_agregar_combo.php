<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 11/06/2017
 * Time: 05:05 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";

include "../../controller/ClassControllerVentas.php";
include "../../controller/ClassControllerCarritoVentas.php";


$connect = new ClassControllerVentas();
$connect->valida_session_id();

$carrito = new ClassControllerCarritoVentas();

header("Content-type:application/json");

$idCombo = $_POST['idcombo'];
$Descripcion = $_POST['descripcion'];

$connect->_query = "SELECT a.idcombo,b.idproducto,b.tipo_producto 
FROM combos as a 
LEFT JOIN detalle_combo as b 
ON a.idcombo = b.idcombo
where a.idcombo = $idCombo";

$connect->get_result_query();
$listaCombo = $connect->_rows;

for($i=0;$i <= count($listaCombo);$i++){

    $idProducto = $listaCombo[$i][1];
    $TipoProducto = $listaCombo[$i][2];

    if($listaCombo[$i][2] == "ART"){
        //REgistrar Producto
        $connect->_query = "SELECT nombre_articulo FROM articulos WHERE idarticulo =  $idProducto ";
        $connect->get_result_query();

        $NombreProducto = $connect->_rows[0][0];
        $dataArt[] = array(
          "idproducto"=>$idProducto,
            "tipo_producto"=>$TipoProducto,
                "nombre_producto"=>$NombreProducto,
            "nombre_producto2"=>$NombreProducto,
            "descripcion"=>$Descripcion,
            "cantidad"=>1
        );

    }else if($listaCombo[$i][2] == "MAT"){
        //Registrar material
        $connect->_query = "SELECT nombre_material FROM materiales WHERE idmateriales =  $idProducto ";
        $connect->get_result_query();

        $NombreProducto = $connect->_rows[0][0];
        $dataMat[] = array(
            "idproducto"=>$idProducto,
            "tipo_producto"=>$TipoProducto,
            "nombre_producto"=>$NombreProducto,
            "nombre_producto2"=>$NombreProducto,
            "descripcion"=>$Descripcion,
            "cantidad"=>1
        );

    }

}

echo json_encode(
  array(
      "result"=>"success",
      "mensaje"=>"ok",
      "data"=>array(
          "ART"=>$dataArt,
          "MAT"=>$dataMat
      )
  )
);
