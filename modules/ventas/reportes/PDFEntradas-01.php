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
	a.Folio,
    a.FolioLlave,
    a.idempresa,
    a.iddepartamento,
    b.nombre_departamento,
    a.idtipo,
    a.idconcepto,
    a.importe,
    a.observaciones,
    a.idusuario_solicita,
    c.nick_name,
    a.idusuario_autoriza,
    d.nick_name,
    a.idusuario_cancela,
    e.nick_name,
    a.idestatus,
    a.fecha_registro,
    date(a.fecha_registro)as Fecha,
    time(a.fecha_registro)as Hora,
    a.idestatus_registro
FROM entradas as a 
LEFT JOIN departamentos as b 
ON a.iddepartamento = b.iddepartamento 
LEFT JOIN perfil_usuarios as c 
ON a.idusuario_solicita = c.idusuario
LEFT JOIN perfil_usuarios as d 
ON a.idusuario_autoriza = d.idusuario
LEFT JOIN perfil_usuarios as e 
ON a.idusuario_cancela = e.idusuario
where a.Folio = '$Folio'
";
$connect->get_result_query();

//Datos de la Consulta de Entrada
$TipoMovimiento = "Entrada";


$NombreDepartamento = $connect->_rows[0][4];
$TipoEntrada = $connect->_rows[0][5];
$Solicitante = $connect->_rows[0][10];
$Autorizante = $connect->_rows[0][12];
$UsuarioCancela = $connect->_rows[0][14];
$Importe = $connect->setFormatoMoneda($connect->_rows[0][7],'pesos');
$Estatus = $connect->_rows[0][15];
$EstatusRegistro = $connect->_rows[0][19];
$FechaRegistro = $connect->_rows[0][16];

if($TipoEntrada == "E"){
    $TituloPDF = "Solicitud de Entrada";
    $TipoMovimiento = "Entrada";
}else{
    $TituloPDF = "Solicitud de Salida";
    $TipoMovimiento = "Salida";
}

if($_REQUEST['pc'] == 3 ){
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
                <td style="background: <?=$Background?>;width: 30%;padding: 5px">Sucursal</td>
                <td style="width: 50%;padding: 5px"><?=$NombreDepartamento?></td>
            </tr>
            <tr>
                <td style="background: <?=$Background?>;width: 30%;padding: 5px">Usuario Solicita</td>
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
$pdf->output($TipoMovimiento.date("YmdHis").'.pdf');
?>