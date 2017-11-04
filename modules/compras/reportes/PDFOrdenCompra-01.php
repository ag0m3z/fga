<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 25/09/2017
 * Time: 11:28 AM
 */

include "../../../core/core.class.php";
include "../../../core/sesiones.class.php";
include "../controllers/ControllerCompras.php";

require_once '../../../plugins/html2pdf/html2pdf.class.php';

$connect = new ControllerCompras();

$Background = "#F3F3F3";

$RowsCompras = $connect->getListaCompra(array("idcompra"=>$_REQUEST['id'],"idempresa"=>$_SESSION['data_home']['idempresa']));

$DomicilioSucursal = "Calle avenida sendero division norte # 135 Local 123";
$TelefonoSucursal = "81 2132-356 - 044 81 2134-4567";
$Logotipo = "../../../site_design/img/logos/".$_SESSION['data_home']['logotipo'];
ob_start();
?>

    <page backtop="20mm" backbottom="10mm" backleft="2mm" backright="2mm">
        <page_header>
            <table style="width: 100%; border-bottom: solid 1px black;">
                <tr>
                    <td style="text-align: left;width: 25%">
                        <img style="width: 95px;height: 57px;" src="<?=$Logotipo?>">
                    </td>
                    <td style="text-align: center;    width: 50%"></td>
                    <td style="text-align: right;    width: 25%"> Orden de Compra </td>
                </tr>
            </table>
        </page_header>
        <page_footer>
            <table style="width: 100%; border-bottom: solid 1px black;">
                <tr>
                    <td style="text-align: left;    width: 50%"><?=$_SESSION['data_home']['nombre_empresa']?></td>
                    <td style="text-align: right;    width: 50%">Pagina [[page_cu]] de [[page_nb]]</td>
                </tr>
            </table>
        </page_footer>
        <table style="width: 100%;border: solid 1px #000; border-collapse: collapse" align="center">
            <tr>
                <td style="width: 100%;text-align: center">
                    <h3><?=$_SESSION['data_home']['nombre_empresa']?></h3>
                    <?=$DomicilioSucursal?><br>
                    <?=$TelefonoSucursal?><br><br>
                    <b style="font-size: 22px">Folio: <?=$RowsCompras[0][3]?></b>
                </td>
            </tr>
        </table>

        <br>
        <table style="width: 100%;border: solid 1px #000; border-collapse: collapse" align="center">
            <tr>
                <td style="width: 15%;border: solid 1px #000;background: <?=$Background?> ;padding: 5px; text-align: left;"><b>Proveedor:</b></td>
                <td style="width: 25%;border: solid 1px #000;padding: 5px; text-align: left;"><?=$RowsCompras[0][11]?></td>
                <td style="width: 30%;border-right: solid 1px #000;padding: 5px; text-align: left;"></td>
                <td style="width: 15%;border: solid 1px #000;background: <?=$Background?>;padding: 5px; text-align: left;"><b>Fecha Reg.:</b></td>
                <td style="width: 15%;border: solid 1px #000;padding: 5px; text-align: center;"><b><?=$RowsCompras[0][13]?></b></td>
            </tr>
            <tr>
                <td style="width: 15%;border: solid 1px #000;background: <?=$Background?> ;padding: 5px; text-align: left;"><b>Telefono:</b></td>
                <td style="width: 25%;border: solid 1px #000;padding: 5px; text-align: left;"><?=$RowsCompras[0][12]?></td>
                <td style="width: 30%;border-right: solid 1px #000;padding: 5px; text-align: left;"></td>
                <td style="width: 15%;border: solid 1px #000;background: <?=$Background?> ;padding: 5px; text-align: left;"><b>Fecha Imp.:</b></td>
                <td style="width: 15%;border: solid 1px #000;padding: 5px; text-align: center;"><?=date("Y-m-d")?></td>
            </tr>
        </table>

        <br>
        <table style="width: 100%;border: solid 1px #000; border-collapse: collapse" align="center">
            <thead>
            <tr>
                <th colspan="4" style="width: 100%;padding: 8px; text-align: center; border: solid 1px #000; background: <?=$Background?>">
                    Detalle
                </th>
            </tr>
            <tr>
                <th style="width: 10%;padding: 8px; text-align: center; border: solid 1px #000; background: <?=$Background?>">Cantidad</th>
                <th style="width: 45%;padding: 8px; text-align: left; border: solid 1px #000; background: <?=$Background?>">Descripción</th>
                <th style="width: 15%;padding: 8px; text-align: center; border: solid 1px #000; background: <?=$Background?>">Precio U</th>
                <th style="width: 15%;padding: 8px; text-align: center; border: solid 1px #000; background: <?=$Background?>">Importe</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if(count($RowsCompras)>0){

                for($i=0;$i<count($RowsCompras);$i++){

                    $importe = ($RowsCompras[$i][7] * $RowsCompras[$i][8]);
                    $TotalImporte = ( $TotalImporte + $importe );
                    echo "
                    <tr>
                    <td style='width: 10%;padding: 5px; text-align: center; border: solid 1px #000;'>".$RowsCompras[$i][7]."</td>
                    <td style='width: 60%;padding: 5px; text-align: left; border: solid 1px #000;'>".$RowsCompras[$i][6]."</td>
                    <td style='width: 15%;padding: 5px; text-align: right; border: solid 1px #000;'>".$connect->setFormatoMoneda($RowsCompras[$i][8],'pesos')."</td>
                    <td style='width: 15%;padding: 5px; text-align: right; border: solid 1px #000;'>".$connect->setFormatoMoneda($importe,'pesos')."</td>
                    </tr>
                    ";
                }
            }

            if(count($RowsCompras) <= 5){

                for($i=0;$i<(7 -count($RowsCompras)) ;$i++){


                    echo "
                    <tr>
                    <td style='width: 10%;padding: 5px; text-align: left; border: solid 1px #000;'>&nbsp;</td>
                    <td style='width: 60%;padding: 5px; text-align: left; border: solid 1px #000;'>&nbsp;</td>
                    <td style='width: 15%;padding: 5px; text-align: right; border: solid 1px #000;'>&nbsp;</td>
                    <td style='width: 15%;padding: 5px; text-align: right; border: solid 1px #000;'>&nbsp;</td>
                    </tr>
                    ";
                }
            }
            echo "<tr><td style='width: 70%;padding: 5px; text-align: right; border-right: solid 1px #000;' colspan='2'></td>
                        <td style='width: 15%;padding: 5px; text-align: right; border: solid 1px #000;background: ".$Background.";'><b>Total:</b></td>
                        <td style='width: 15%;padding: 5px; text-align: right; border: solid 1px #000;'>".$connect->setFormatoMoneda($TotalImporte,'pesos')."</td></tr>";
            ?>
            </tbody>
        </table>
        <br>
        <table style="width: 100%;border: solid 1px #000; border-collapse: collapse" align="center">
            <tr>
                <td  style='width: 100%;padding: 5px; text-align: left; border: solid 1px #000;background: <?=$Background?>'>Sucursal de Entrega</td>
            </tr>
            <tr>
                <td style='width: 100%;padding: 5px; text-align: left; border: solid 1px #000;'>
                    <br>
                    <?=$RowsCompras[0][15]?><br/>
                    <?=$RowsCompras[0][16]?><br/>
                    <?=$RowsCompras[0][17]?> -
                    <?=$RowsCompras[0][18]?><br/>
                </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td  style='width: 100%;padding: 5px; text-align: left; border: solid 1px #000;background: <?=$Background?>'>Observaciones</td>
            </tr>
            <tr>
                <td style='width: 100%;padding: 5px; text-align: left; border: solid 1px #000;'>
                    &nbsp;<br><br><br><br><br><br>
                </td>
            </tr>
        </table>


    </page>
<?php
$content = ob_get_clean();
$pdf = new HTML2PDF('P','Letter','es','UTF-8');
$pdf->writeHTML($content);
$pdf->pdf->IncludeJS('print(TRUE)');
$pdf->output('Reporte_'.date("YmdHis").'.pdf');

?>