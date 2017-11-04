<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 16/09/2017
 * Time: 10:34 AM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();
$connect->valida_session_id();
$idEmpresa = $_SESSION['data_home']['idempresa'];

$connect->_query = "
SELECT idcatalogo,opc_catalogo,nombre_catalogo,moneda1 FROM catalogo_general where idcatalogo = 7 and idestado = 1 and idempresa = $idEmpresa order by fecha_alta DESC;
";
$connect->get_result_query();

for($i=0;$i<count($connect->_rows);$i++){

    $idCosto = $connect->_rows[$i][1];

    echo "<tr>
    <td>".$connect->_rows[$i][2]."</td>
    <td>".$connect->_rows[$i][3]."</td>
    <td><button class='btn btn-xs btn-danger' onclick='fnGnEliminarCostoTrabajo(".$idCosto.")' title='Eliminar'><i class='fa fa-trash'></i></button></td>
    </tr>";
}