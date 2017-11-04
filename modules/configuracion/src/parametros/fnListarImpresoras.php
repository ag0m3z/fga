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
SELECT a.idcatalogo,a.opc_catalogo,a.opc_catalogo2,b.nombre_departamento,a.nombre_catalogo,a.descripcion_catalogo FROM catalogo_general as a left JOIN departamentos as b on a.opc_catalogo2 = b.iddepartamento where a.idcatalogo = 8 and a.idestado = 1 and a.idempresa = $idEmpresa order by a.fecha_alta DESC;
";
$connect->get_result_query();

for($i=0;$i<count($connect->_rows);$i++){

    $idImpresora = $connect->_rows[$i][1];
    $idSucursal = $connect->_rows[$i][2];

    echo "<tr>
    <td>".$connect->_rows[$i][3]."</td>  
    <td>".$connect->_rows[$i][4]."</td>
    <td>".$connect->_rows[$i][5]."</td>
    <td><button class='btn btn-xs btn-danger' onclick='fnGnEliminarImpresora(".$idImpresora.",".$idSucursal.")' title='Eliminar'><i class='fa fa-trash'></i></button></td>
    </tr>";
}