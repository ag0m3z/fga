<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 08/06/2017
 * Time: 10:01 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../controller/ClassControllerReports.php";

$connect = new ClassControllerReports();
$connect->valida_session_id();

/**
 * EL corte diario
 * Reporte de todas las ventas del dia actual
 * Perfil administrador puede ver por todas las sucursales, los
 * demas usuario solo veran lo de su sucursal
 */

$lista = $connect->getMovimientosDiario(array('idperfil'=>$_SESSION['data_login']['idperfil'],'iddepartamento'=>$_SESSION['data_home']['iddepartamento']));
$a=1;
$Total =0;

echo "<table class='table table-hover table-condensed'><thead><tr><th>#</th><th>Folio</th><th>Cliente</th><th>Sucursal</th><th>Importe Venta</th><th>Importe Pago</th></tr></thead><tbody>";
if(count($lista) > 0){

    for($i=0;$i < count($lista);$i++){

        echo "<tr>
        <td>".$a++."</td>
        <td>".$connect->getFormatFolio($lista[$i][2],4)."</td>
        <td>".$lista[$i][13]."</td>
        <td>".$lista[$i][14]."</td>
        <td width='130' class='currency text-right ' >".$lista[$i][6]."</td>
        <td width='130' class='currency text-right' >".$lista[$i][7]."</td>
        </tr>";
        $Total = $Total + $lista[$i][7];
    }
}
echo "<tr><td colspan='5' class='text-right text-bold'>Importe Total</td><td class='text-right currency'>".$Total."</td></tr></tbody></table>";
?>
<script src="<?=\core\core::ROOT_APP()?>site_design/js/js_formato_moneda.js"></script>
<script>
    $('.currency').numeric({prefix:'$ ', cents: true});
</script>