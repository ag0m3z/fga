<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 28/06/2017
 * Time: 08:55 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();
$connect->valida_session_id();

$FolioVenta = $_POST['folio_venta'];

$connect->_query = "SELECT 
	b.idventa,
	lpad(b.idventa,4,'0'),
	g.nombre_departamento,
	e.nick_name,
	f.nombre_completo,
	d.nombre_articulo,
    b.cantidad,
    b.precio_compra,
    b.tipo_articulo,
    b.descripcion,
    a.costo_trabajo_cp,
    a.idcliente,
    a.iddepartamento,
    a.idusuario,
    a.descripcion_general,
    a.idtipo_venta
FROM detalle_venta as b 
left join venta as a 
on b.idventa = a.idventa
left join articulos as d 
on b.idarticulo= d.idarticulo
left join perfil_usuarios as e 
on a.idusuario = e.idusuario 
left join clientes as f 
on a.idcliente = f.idcliente 
left join departamentos as g 
on a.iddepartamento = g.iddepartamento
where b.idventa = $FolioVenta";

$connect->get_result_query();
$ListaVenta = $connect->_rows;

$connect->_query = "SELECT 
	a.fecha_registro,
    a.importe_pagado,
    a.idestatus,
    a.NoPago
FROM movimientos_caja as a
where a.idventa = $FolioVenta";

$connect->get_result_query();
$ListaPagos = $connect->_rows;

$FolioVenta = $ListaVenta[0][1];
$NombreSucursal = $ListaVenta[0][2];
$FechaVenta = $ListaVenta[0][11];
$Vendedor = $ListaVenta[0][3];
$ClienteVenta = $ListaVenta[0][4];


$Titulo = "FGA Servicios de Impresion";

$DomicilioSucursal = "Calle avenida sendero division norte # 135 Local 123";
$TelefonoSucursal = "81 2132-356 - 044 81 2134-4567";
?>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/js_formato_moneda.js"></script>
<script>
    $('.currency').numeric({prefix:'$ ', cents: true});
    if ( jsPrintSetup ) {
        //Es seguro ejecutar la función
        jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);
        // set top margins in millimeters
        jsPrintSetup.setOption('marginTop', -20);
        jsPrintSetup.setOption('marginBottom', 0);
        jsPrintSetup.setOption('marginLeft', -12);
        jsPrintSetup.setOption('marginRight', 0);

        jsPrintSetup.setPrinter('<?=$_SESSION['myPrint']?>');
        jsPrintSetup.setSilentPrint(1);


        setTimeout(function () {
            jsPrintSetup.printWindow(window);
            // print desired frame
            //    jsPrintSetup.printWindow(window.frames[0]);
            jsPrintSetup.setSilentPrint(0);
        },500);
    }
    else {
        ///alert('JS Print Setup Extension is NOT installed');
        MyAlert("No se ecnontro el componente, ","error");
    }

       /* // set portrait orientation
        jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);
        // set top margins in millimeters
        jsPrintSetup.setOption('marginTop', 5);
        jsPrintSetup.setOption('marginBottom', 5);
        jsPrintSetup.setOption('marginLeft', 5);
        jsPrintSetup.setOption('marginRight', 5);

        jsPrintSetup.setPrinter('');
        jsPrintSetup.setSilentPrint(1);

        // set page header
        jsPrintSetup.setOption('headerStrLeft', '');
        jsPrintSetup.setOption('headerStrCenter', '');
        jsPrintSetup.setOption('headerStrRight', '');
        // set empty page footer
        jsPrintSetup.setOption('footerStrLeft', '');
        jsPrintSetup.setOption('footerStrCenter', '');
        jsPrintSetup.setOption('footerStrRight', '');



        jsPrintSetup.setOption('printRange',jsPrintSetup.kRangeSpecifiedPageRange);
        jsPrintSetup.setOption('startPageRange', 1);
        jsPrintSetup.setOption('endPageRange', 1);



        setTimeout(function () {
            jsPrintSetup.printWindow(window);
            // print desired frame
            //    jsPrintSetup.printWindow(window.frames[0]);
            jsPrintSetup.setSilentPrint(0);
        },500);
*/

</script>
<body>
<div class="row">
    <div class="col-md-12">

        <div style="width: 980px !important;">
            <table class="table table-bordered table-condensed no-margin" >
                <thead>
                <tr>
                    <th width="180" class="text-center" style="vertical-align: text-top;" rowspan="2"><img src="site_design/img/logos/logo_200px.jpg" class="img-responsive" ></th>
                    <th style="text-align: center"><h3><?=$Titulo?></h3></th>
                    <th width="180" class="text-center"  style="vertical-align: text-top;" rowspan="2">
                        Folio: <span class="text-red"><?=$FolioVenta?></span><br>
                        <span class="small" >Vendedor<br>
                            <?=$Vendedor?></span>
                    </th>
                </tr>
                <tr>
                    <th style="text-align: center">
                        <span class="small">
                            Sucursal: <?=$NombreSucursal?><br>
                            Domicilio: <?=$DomicilioSucursal?><br>
                            Telefonos: <?=$TelefonoSucursal?><br>
                        </span>
                    </th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <table class="table small table-bordered table-hover table-condensed">
                <thead>
                <tr>
                    <th width="100">Cantidad</th>
                    <th colspan="3">Descripción</th>
                    <th class="hidden" width="100">Precio U.</th>
                    <th class="hidden" width="100">Importe</th>
                </tr>
                </thead>
                <tbody>
                <?php
                for($i=0;$i<count($ListaVenta);$i++){

                    if($ListaVenta[$i][8] == "ART"){
                        echo "<tr>
                    <td rowspan='2' >".$ListaVenta[$i][6]."</td>
                    <td colspan='3'>".$ListaVenta[$i][5]."</td>
                    </tr>";
                        echo '<tr>
                    <td colspan="3">'.$ListaVenta[$i][9].'</td>
                    </tr>';
                    }

                    $TotalImporte = ($ListaVenta[$i][7] * $ListaVenta[$i][6]) + $TotalImporte;
                }
                $TotalImporte = $TotalImporte + $ListaVenta[0][10];
                ?>
                <tr>
                    <td colspan="4">
                        <b>Descripción General</b><br>
                        <?=$ListaVenta[0][14]?>
                    </td>
                </tr>

                <tr>
                    <td colspan="3" class="text-right text-bold" >Total: </td>
                    <td class="text-center currency text-bold" ><?=$TotalImporte?></td>
                </tr>
                <?php
                if(count($ListaPagos)>0){
                    $TotalPagos = 0;
                    for($i=0;$i < count($ListaPagos); $i++){


                        $SignoPago = "-";
                        if($ListaPagos[$i][2] == "A"){
                            $TotalPagos = $TotalPagos + $ListaPagos[$i][1] ;
                            $SignoPago = "+";
                        }

                        echo "<tr>
                                <td colspan='1'></td>
                                <td class=' text-right' >".$ListaPagos[$i][0]."</td>
                                <td class='text-right'>Pago ".$ListaPagos[$i][2]." # ".$ListaPagos[$i][3].": </td>
                                <td class='text-center'> ".$SignoPago." <span class=' currency'>".$ListaPagos[$i][1]."</span></td>
                                </tr>";

                    }
                }
                ?>
                <tr>
                    <td colspan="1"></td>
                    <td colspan="2" class="text-bold text-right">Saldo Pendiente:</td>
                    <td class="text-bold text-center currency"><?=($TotalImporte - $TotalPagos)?></td>
                </tr>
                </tbody>
            </table>
        </div>


    </div>
</div>

</body>