<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 16/06/2017
 * Time: 11:27 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";

include "../../controller/ClassControllerVentas.php";

$connect = new ClassControllerVentas();
$connect->valida_session_id();

if(!array_key_exists('idcliente',$_POST) && !array_key_exists('folio_venta',$_POST) && !empty($_POST['idcliente']) && !empty($_POST['folio_venta'])){
    \core\core::MyAlert("No se encontro el id del cliente o el folio de venta","alert");
    exit();
}

$FolioVenta = $_POST['folio_venta'];
$idCliente = $_POST['idcliente'];

$connect->_query = "SELECT 
                      a.iddetalle_venta,a.idalmacen,a.idventa,a.tipo_articulo,b.nombre_articulo,a.cantidad,a.precio_compra,a.descripcion,a.costo_trabajo_cp 
                    FROM 
                      detalle_venta as a
                      LEFT JOIN articulos as b
                      ON a.idarticulo = b.idarticulo
                    where a.idventa = $FolioVenta";
$connect->get_result_query();
$DetalleART = $connect->_rows;


//Numeros de pagos
$connect->_query = "
SELECT idmovimiento,NoPago,Importe,TotalPagado,FechaMovimiento,idestatus FROM movimientos_caja WHERE idventa = $FolioVenta ORDER BY NoPago DESC
";
$connect->get_result_query();
$DetallePagos = $connect->_rows;
sleep(3);
$a=1;
?>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/js_formato_moneda.js"></script>
<script>
    $("th").addClass("bg-bareylev");
    $('.currency').numeric({prefix:'$ ', cents: true});
</script>
<div class="col-md-7">
    <table class="table table-striped table-condensed table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio U</th>
            <th>Sub Total</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $SubTotalART=0;
        for($i=0;$i < count($DetalleART);$i++){

            $PrecioSubtotal = ($DetalleART[$i][6] + $DetalleART[$i][8]) * $DetalleART[$i][5];
            echo "<tr><td>".$a++."</td>
                    <td>".$DetalleART[$i][4]."</td>
                    <td>".$DetalleART[$i][5]."</td>
                    <td class='currency'>".$DetalleART[$i][6]."</td>
                    <td class='currency text-right'>".$PrecioSubtotal."</td>
                    </tr>";
            $SubTotalART = $SubTotalART + $PrecioSubtotal;
        }
        ?>
        </tbody>
        <tbody>
        <tr>
            <td colspan="3" class="text-right text-bold">Total: </td>
            <td colspan="3" class="text-right text-bold currency"><?=$PrecioSubtotal?></td>
        </tr>
        </tbody>
    </table>


</div>

<div class="col-md-5">
    <table class="table table-striped table-condensed table-hover">
        <thead>
        <tr>
            <th>No Pago</th>
            <th>Importe</th>
            <th>Pago</th>
            <th>Estatus</th>
            <th>Fecha</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $a=1;

        for($i=0;$i < count($DetallePagos);$i++){
            echo "<tr>
                    <td>".$DetallePagos[$i][1]."</td>
                    <td class='currency' >".$DetallePagos[$i][2]."</td>
                    <td class='currency' >".$DetallePagos[$i][3]."</td>
                    <td>".$DetallePagos[$i]['idestatus']."</td>
                    <td>".$DetallePagos[$i][4]."</td>
                    </tr>";

            $Importe = $DetallePagos[0][2];

            if($DetallePagos[$i]["idestatus"]=="A"){
                $Pagos = $Pagos + $DetallePagos[$i][3];
            }

        }
        $Total = $Importe - $Pagos;
        ?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="2" class="text-bold text-right">Pendiente: </td>
            <td class="text-bold currency"><?=$Total?></td>
            <td>
                <?php
                if(!$Total <  $DetallePagos[0][2]){
                    echo "<span class='label label-warning'> Nota Pendiente</span>";
                }else{
                    echo "<span class='label label-success'> Nota Terminada</span>";
                }
                ?>
            </td>
        </tr>
        </tfoot>
    </table>
</div>
