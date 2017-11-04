<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 11/06/2017
 * Time: 03:36 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";

include "../../controllers/ClassControllerCartCombos.php";

$carrito = new ClassControllerCartCombos();


$dataProductos = $carrito->imprime_carrito();
$a = 1;

for($i=0;$i < count($dataProductos); $i++){


    echo "<tr>
            <td>".$a++."</td>
            <td>".$dataProductos[$i]['tipo_producto']."</td>
            <td>".$dataProductos[$i]['nombre']."</td>
            <td><a href='#' onclick='elimina_producto_combo(".$i.")'><i class='fa fa-trash'></i></a></td>
         </tr>";

}