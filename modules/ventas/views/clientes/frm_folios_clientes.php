<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 16/06/2017
 * Time: 11:01 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";

include "../../controller/ClassControllerVentas.php";

$connect = new ClassControllerVentas();
$connect->valida_session_id();

if(!array_key_exists('idcliente',$_POST) && !empty($_POST['idcliente'])){
    \core\core::MyAlert("No se encontro el id del cliente","alert");
    exit();
}

$idCliente = $_POST['idcliente'];
$connect->_query = "
select 
	a.idventa, 
    b.correo,
    b.telefono,
    b.celular
from clientes as b 
left join venta as a
on a.idcliente = b.idcliente
where b.idcliente = $idCliente ORDER BY a.idventa DESC
";
$connect->get_result_query();
$a=1;

if(count($connect->_rows) >= 1 ){
    for($i=0;$i < count($connect->_rows);$i++){

        if($connect->_rows[$i][0] >= 1){
            echo "<tr onclick='fnVentaHistorialCliente({\"opc\":4,\"folio_venta\":".$connect->_rows[$i][0].",\"idcliente\":".$idCliente."})' style='cursor: pointer' ><td>".$a++."</td><td>".$connect->getFormatFolio($connect->_rows[$i][0],4)."</td></tr></a>";
        }
    }
}else{
    echo "<tr><td></td></tr>";
}

?>
<script>

    $("#lista_folios_cte tr td").click(function () {
        $("#lista_folios_cte tr td").removeClass('bg-light-blue-gradient');
        $(this).addClass('bg-light-blue-gradient');
    });
    $("#detalle_venta").html('');

    $("#telefono_cliente").val('<?=$connect->_rows[0][2]?>');
    $("#celular_cliente").val('<?=$connect->_rows[0][3]?>');
    $("#correo_cliente").val('<?=$connect->_rows[0]['correo']?>');
</script>