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
$Folio = $_REQUEST['id'];
$connect->_query = "
SELECT 
	a.idFolio,
    a.idLlave,
    a.idempresa,
    a.iddepartamento,
    b.nombre_departamento,
    a.idtipo,
    a.importe,
    f.Nombre as Origen,
    g.Nombre as Destino,
    a.descripcion,
    a.idusuario_registro,
    c.nick_name,
    a.idusuario_autoriza,
    d.nick_name,
    a.idusuario_cancelacion,
    e.nick_name,
    a.idestatus,
    a.fecha_registro,
    date(a.fecha_registro)as Fecha,
    time(a.fecha_registro)as Hora,
    a.idestatus_registro 
FROM aportaciones as a 
LEFT JOIN departamentos as b 
ON a.iddepartamento = b.iddepartamento 
LEFT JOIN perfil_usuarios as c 
ON a.idusuario_registro = c.idusuario
LEFT JOIN perfil_usuarios as d 
ON a.idusuario_autoriza = d.idusuario
LEFT JOIN perfil_usuarios as e 
ON a.idusuario_cancelacion = e.idusuario 
LEFT JOIN cajas as f 
ON a.idsucursal_origen = f.idcaja 
LEFT JOIN cajas as g 
ON a.idsucursal_destino = g.idcaja 
where a.idFolio = '$Folio'
";
$connect->get_result_query();

//Datos de la Consulta de Entrada
$TipoMovimiento = "Aportacion";


$NombreDepartamento = $connect->_rows[0][4];
$TipoEntrada = $connect->_rows[0][5];
$Solicitante = $connect->_rows[0][11];
$Autorizante = $connect->_rows[0][13];
$UsuarioCancela = $connect->_rows[0][15];
$Importe = $connect->setFormatoMoneda($connect->_rows[0][6],'pesos');
$Origen = $connect->_rows[0][7];
$Destino = $connect->_rows[0][8];
$Descripcion = $connect->_rows[0][9];
$Estatus = $connect->_rows[0][16];
$EstatusRegistro = $connect->_rows[0][20];
$FechaRegistro = $connect->_rows[0][17];

if($TipoEntrada == "A"){
    $TituloPDF = "Solicitud de Aportación";
    $TipoMovimiento = "Aportación";
}else{
    $TituloPDF = "Solicitud de Retiro";
    $TipoMovimiento = "Retiro";
}

if($_REQUEST['pc'] == 4){
    $TituloPDF = "Cancelació de ".$TipoMovimiento;
    $TipoMovimiento = $TituloPDF;
}else{
    if($EstatusRegistro == "C"){
        $TituloPDF = "Cancelació de ".$TipoMovimiento;
        $TipoMovimiento = $TituloPDF;
    }
}
//Datos del la empresa

$Background = "#F3F3F3";
$DomicilioSucursal = "Calle avenida sendero division norte # 135 Local 123";
$TelefonoSucursal = "81 2132-356 - 044 81 2134-4567";
$Logotipo = "../../../site_design/img/logos/".$_SESSION['data_home']['logotipo'];

ob_start();
?>

    <page  backtop="20mm" backbottom="10mm" backleft="2mm" backright="2mm">
        <page_header>
            <table style="width: 100%; border-bottom: solid 1px black;">
                <tr>
                    <td style="text-align: left;width: 25%">
                        <img style="width: 95px;height: 57px;" src="<?=$Logotipo?>">
                    </td>
                    <td style="text-align: center;    width: 50%"></td>
                    <td style="text-align: right;    width: 25%"> <?=$TituloPDF?> </td>
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
                    <h2><?=$_SESSION['data_home']['nombre_empresa']?></h2>
                    <?=$DomicilioSucursal?><br>
                    <?=$TelefonoSucursal?>
                </td>
            </tr>
        </table><br><br><br>

        <h3 style="text-align: center">Folio Transacción<br><?=$Folio?></h3>

        <?php
        //Formato para Entradas
        ?>
        <table style="width: 80%;border: solid 1px #000;" align="center">
            <tr>
                <td style="background: <?=$Background?>;width: 30%;padding: 5px">Tipo de Transacción</td>
                <td style="width: 50%;padding: 5px"><?=$TipoMovimiento?></td>
            </tr>
            <tr>
                <td style="background: <?=$Background?>;width: 30%;padding: 5px">Fecha y Hora</td>
                <td style="width: 50%;padding: 5px"><?=$FechaRegistro?></td>
            </tr>
            <tr>
                <td style="background: <?=$Background?>;width: 30%;padding: 5px">Origen</td>
                <td style="width: 50%;padding: 5px"><?=$Origen?></td>
            </tr>
            <tr>
                <td style="background: <?=$Background?>;width: 30%;padding: 5px">Destino</td>
                <td style="width: 50%;padding: 5px"><?=$Destino?></td>
            </tr>
            <tr>
                <td style="background: <?=$Background?>;width: 30%;padding: 5px">Usuario Solicitante</td>
                <td style="width: 50%;padding: 5px"><?=$Solicitante?></td>
            </tr>
            <tr>
                <td style="background: <?=$Background?>;width: 30%;padding: 5px">Usuario Autoriza</td>
                <td style="width: 50%;padding: 5px"><?=$Autorizante?></td>
            </tr>
            <tr>
                <td style="background: <?=$Background?>;padding: 5px;">Importe</td>
                <td style="width: 50%;padding: 5px"><?=$Importe?></td>
            </tr>
            <tr>
                <td style="background: <?=$Background?>;padding: 5px;">Estatus</td>
                <td style="width: 50%;padding: 5px"><?=$Estatus?></td>
            </tr>
            <tr>
                <td style="background: <?=$Background?>;padding: 5px;">Descripción</td>
                <td style="width: 50%;padding: 5px"><?=$Descripcion?></td>
            </tr>
        </table>
        <?php
        // Formato para Cancelacion de Entradas
        ?>
        <br>
        <br><br><br><br><br><br>

        <table style="width: 40%;text-align: center" align="center">
            <tr>
                <td style="border-bottom: 1px solid #000000;width: 100%"></td>
            </tr>
            <tr>
                <td>Nombre y Firma</td>
            </tr>
        </table>


    </page>
<?php
$content = ob_get_clean();
$pdf = new HTML2PDF('P','Letter','es','UTF-8');
$pdf->writeHTML($content);
$pdf->pdf->IncludeJS('print(TRUE)');
$pdf->output('Retiro'.date("YmdHis").'.pdf');

?>