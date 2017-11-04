<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 02/06/2017
 * Time: 10:59 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";


$connect = new \core\seguridad();

$idEmpresa = $_SESSION['data_home']['idempresa'];
$idAlmacen = $_SESSION['data_home']['almacen'];
$textSearch = $_POST['textSearch'];

$connect->_query = "
SELECT b.idarticulo,ifnull(a.idalmacen,0),b.nombre_articulo,ifnull(a.existencias,0),b.precio_venta
FROM articulos as b
LEFT JOIN almacen_articulos as a
ON b.idarticulo = a.idarticulo 
WHERE b.idempresa = $idEmpresa and b.tipo = 1 AND b.nombre_articulo LIKE '%$textSearch%' ORDER BY a.existencias DESC
";

$connect->get_result_query();
$lista = $connect->_rows;

$a=0;

for($i=0;$i < count($lista);$i++){

    $valor = $lista[$i][0]."-".$lista[$i][2] ;
    $NombreProducto = $lista[$i][2];
    $precio_venta = $lista[$i][4];
    $idArticulo = $lista[$i][0];

    if($lista[$i][1] == $idAlmacen || $lista[$i][1] == 0){
        echo "<tr><td style='cursor: pointer' onclick='getCrearTrabajo(1,{valor:\"".$valor."\",NombreProducto:\"".$NombreProducto."\"})'>".$lista[$i][2]."</td><td class='text-center' >".(int) ($lista[$i][3])."</td><td>".$lista[$i][4]."</td><td><button class='btn btn-sm btn-success' onclick='getCrearTrabajo(1,{valor:\"".$valor."\",NombreProducto:\"".$NombreProducto."\"})' ><i class='fa fa-plus'></i></button></td></tr>";
    }

}