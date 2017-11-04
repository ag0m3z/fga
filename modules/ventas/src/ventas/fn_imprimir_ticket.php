<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 07/06/2017
 * Time: 12:13 AM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

require_once '../../../../plugins/html2pdf/html2pdf.class.php';
ob_start();


$connect = new \core\seguridad();
$FolioVenta = $_REQUEST['folio_venta'];

$connect->_query = "SELECT 
	a.idventa,a.iddepartamento,a.idcliente,a.idusuario,b.idarticulo,b.tipo_articulo,
    b.costo_trabajo_cp,b.precio_compra,b.cantidad,b.descripcion,a.fecha_venta 
FROM 
	venta AS a 
LEFT JOIN detalle_venta as b 
ON a.idventa = b.idventa
WHERE a.idventa = $FolioVenta";

$connect->get_result_query();
$ListaVenta = $connect->_rows;

$NombreSucursal = $ListaVenta[0][1];
$FechaVenta = $ListaVenta[0]['fecha_venta'];
$CajeroVenta = $ListaVenta[0][3];
$ClienteVenta = $ListaVenta[0][2];


?>
<page backtop="35mm" backbottom="2mm">

    <style>
        .tablaDetailticket{
            width: 100% !important;
            border-collapse:collapse;
            font-weight: normal;
            font-size:11px;
            table-layout: fixed;
            cellppading:0px;
            cellspacing:0px;
        }
        .tablaDetailticket th{
            height:20px;
            padding:3px;
            background: #f4f4f4;
            font-weight: normal;
            font-size:13px;
        }
        .tablaDetailticket tr{
            cellppading:0px;
            cellspacing:0px;
        }
        .tablaDetailticket td{
            cellppading:0px;
            cellspacing:0px;
            padding:2px;
            font-size: 11px;
        }
    </style>

    <page_header footer='page'>
        <table>
            <tr>
                <td  width="50" rowspan="2"><img style="width: 100px" src="../../../../site_design/img/logos/logo01.png"></td>
                <td align="center"><span style="font-weight:bold;font-size: 25px; text-align: center;vertical-align: text-bottom"><?=$_SESSION['data_home']['nombre_empresa']?></span></td>
                <td rowspan="2"><span  style="font-size:12px;">Folio: </span> <span style="font-size:17px; font-weight: bold; color:red;"><?=$_REQUEST['folio_venta']?></span></td>
            </tr>
            <tr>
                <td width="500" align="center" style="vertical-align:top;">Sucursal <?=$NombreSucursal?></td>
            </tr>
        </table>
        <p style="font-size:13px;">
            Fecha venta: <?=$FechaVenta?><br>
            Cajero: <?=$CajeroVenta?><br/>
            Cliente: <?=$ClienteVenta?>
        </p>
    </page_header>

    <div style="margin-top: 50px;;text-align:center;padding:3px;background:#d4d4d4;border:1px solid #ccc"><strong>Informaci&oacute;n de Reporte</strong></div>

    <table  class="tablaDetailticket" border="1">
        <tr>
            <td  width="25" >#</td>
            <td  width="250" >Producto</td>
            <td  width="45" >Cantidad</td>
            <td  width="70" >Importe u</td>
        </tr>
        <tr>
            <td>1</td>
            <td>Playera verde ch blanco con negra y amarilla </td>
            <td>1</td>
            <td>$ 1,500.00</td>
        </tr>
    </table>

    <table  class="tablaDetailticket" border="1">
        <tr>
            <td  width="25" >#</td>
            <td  width="50" >Producto</td>
            <td  width="15" >Cantidad</td>
            <td  width="70" >Importe u</td>
        </tr>
        <tr>
            <td>1</td>
            <td>Playera </td>
            <td>1</td>
            <td>$ 1</td>
        </tr>
    </table>

<page_footer>
    <table>
        <tr><td><div style="float:left; width:300px; text-align:center; margin-left:50px;border-top:1px solid;">Firma De Entrega</div></td><td><div style="float:left; width:300px; text-align:center; margin-left:50px;border-top:1px solid;">Firma De Recibido</div></td></tr>
    </table>
    <div style="font-size:9px;color:#b4b4b4; text-align:center;"><p>© 2014 Sistema Integral - Prestamo Express</p></div>
    <div style="font-size:9px;color:#b4b4b4; text-align:center;">[[page_cu]]/[[page_nb]]</div>
    <br/>
    <br/>
    <br/>
</page_footer>

</page>
<?php
$content = ob_get_clean();
$pdf = new HTML2PDF('P','A4','fr','UTF-8');
$pdf->writeHTML($content);
$pdf->pdf->IncludeJS('print(TRUE)');
$pdf->output('Reporte.pdf');

?>
