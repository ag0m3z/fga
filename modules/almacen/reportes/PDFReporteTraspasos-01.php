<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 25/09/2017
 * Time: 11:28 AM
 */

include "../../../core/core.class.php";
include "../../../core/sesiones.class.php";
include "../../../core/seguridad.class.php";

require_once '../../../plugins/html2pdf/html2pdf.class.php';

$connect = new \core\seguridad();

$idTraspas = $_REQUEST['id'];

$connect->_query = "
SELECT 
	lpad(a.idtraspaso,4,'0'),a.idtraspaso,a.tipo_articulo,c.codigo,c.nombre_articulo,
	a.cantidad,d.nombre_almacen as AlmacenOrigien,e.nombre_almacen as AlmacenDestino,
    DATE_FORMAT(b.fecha_alta,'%d/%m/%Y'),f.nick_name as UsuarioSolicita,g.nick_name as UsuarioAutoriza 
FROM detalle_traspasos as a 
JOIN traspasos as b 
ON a.idtraspaso = b.idtraspaso 
JOIN articulos as c 
ON a.idarticulo = c.idarticulo 
JOIN almacen as d 
ON b.idalmacen_origen = d.idalmacen 
JOIN almacen as e 
ON b.idalmacen_destino = e.idalmacen 
JOIN perfil_usuarios as f 
ON b.idusuario_solicita = f.idusuario 
LEFT JOIN perfil_usuarios as g 
ON b.idusuario_autoriza = g.idusuario 
WHERE a.idtraspaso = $idTraspas ORDER BY c.nombre_articulo ASC
";

$connect->get_result_query();
$Traspasos = $connect->_rows;

$Background = "#F3F3F3";
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
                    <td style="text-align: right;    width: 25%"> Traspasos </td>
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
                <td style="width: 100%;text-align: left;font-size: 14px;">
                    <b><?=$_SESSION['data_home']['nombre_empresa']?></b><br><br>
                    <b>Folio: </b> <?=$Traspasos[0][0]?><br>
                    <b>Fecha Registro: </b> <?=$Traspasos[0][8]?><br>
                    <b>Fecha Actual: </b> <?=date("d/m/Y")?><br>
                    <b>Solicitante: </b><?=$Traspasos[0][9]?><br>
                    <b>Autorizador: </b><?=$Traspasos[0][10]?><br>

                </td>
            </tr>
        </table>

        <br>
        <table style="width: 100%;border: solid 1px #000; border-collapse: collapse" align="center">
            <tr>
                <td style="width: 17%;border: solid 1px #000;background: <?=$Background?> ;padding: 5px; text-align: left;"><b>Almacen Origen:</b></td>
                <td style="width: 25%;border: solid 1px #000;padding: 5px; text-align: left;"><?=$Traspasos[0][6]?></td>
                <td style="width: 16%;border-right: solid 1px #000;padding: 5px; text-align: left;"></td>
                <td style="width: 17%;border: solid 1px #000;background: <?=$Background?>;padding: 5px; text-align: left;"><b>Almacen Destino:</b></td>
                <td style="width: 25%;border: solid 1px #000;padding: 5px; text-align: left;"><?=$Traspasos[0][7]?></td>
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
                <th style="width: 20%;padding: 8px; text-align: center; border: solid 1px #000; background: <?=$Background?>">Codigo</th>
                <th style="width: 60%;padding: 8px; text-align: center; border: solid 1px #000; background: <?=$Background?>">Descripción</th>
                <th style="width: 10%;padding: 8px; text-align: center; border: solid 1px #000; background: <?=$Background?>">Tip</th>
                <th style="width: 10%;padding: 8px; text-align: left; border: solid 1px #000; background: <?=$Background?>">Cantidad</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if(count($Traspasos)>0){

                $Total = 0;
                for($i=0;$i<count($Traspasos);$i++){

                    echo "
                    <tr>
                    <td style='width: 20%;padding: 5px; text-align: center; border: solid 1px #000;'>".$Traspasos[$i][3]."</td>
                    <td style='width: 60%;padding: 5px; text-align: left; border: solid 1px #000;'>".$Traspasos[$i][4]."</td>
                    <td style='width: 10%;padding: 5px; text-align: center; border: solid 1px #000;'>".$Traspasos[$i][2]."</td>
                    <td style='width: 10%;padding: 5px; text-align: center; border: solid 1px #000;'>".$Traspasos[$i][5]."</td>
                    </tr>
                    ";
                    $Total = $Total + $Traspasos[$i][5];
                }
            }

            if(count($Traspasos) <= 5){

                for($i=0;$i<(7 -count($Traspasos)) ;$i++){


                    echo "
                    <tr>
                    <td style='width: 20%;padding: 5px; text-align: left; border: solid 1px #000;'>&nbsp;</td>
                    <td style='width: 60%;padding: 5px; text-align: left; border: solid 1px #000;'>&nbsp;</td>
                    <td style='width: 10%;padding: 5px; text-align: left; border: solid 1px #000;'>&nbsp;</td>
                    <td style='width: 10%;padding: 5px; text-align: left; border: solid 1px #000;'>&nbsp;</td>
                    </tr>
                    ";
                }
            }

            echo "
                    <tr>
                    <td colspan='2' style='width: 80%;padding: 5px; text-align: left; border-right: solid 1px #000;'>&nbsp;</td>
                    <td style='width: 10%;padding: 5px; text-align: right; border: solid 1px #000;background: ".$Background." '>Total</td>
                    <td style='width: 10%;padding: 5px; text-align: center; border: solid 1px #000;'>".$Total."</td>
                    </tr>
                    ";

            ?>
            </tbody>
        </table>
        <br>
        <table style="width: 100%;border: solid 1px #000; border-collapse: collapse" align="center">
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
$pdf->output('ReporteTraspaso_'.date("YmdHis").'.pdf');

?>