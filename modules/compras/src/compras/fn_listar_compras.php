<?php
/**
 * Created by PhpStorm.
 * User: USUARIO
 * Date: 20/05/2017
 * Time: 12:10 AM
 */
/**
 * Incluir las Librerias Principales del Sistema
 * En el Siguiente Orden ruta de libreias: @@/SistemaIntegral/core/
 *
 * 1.- core.php;
 * 2.- sesiones.php
 * 3.- seguridad.php o modelo ( ej: model_aparatos.php)
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

unset($_SESSION['EXPORT']);

$connect = new \core\seguridad();
$connect->valida_session_id();

$idEstado = $_POST['opc'];

switch ($idEstado){
    case 1:
        break;
    case 2:
        $Botones = "<button class='btn btn-sm btn-default'><i class='fa fa-eye'></i></button> <button class='btn btn-sm btn-success' title='Impimir'><i class='fa fa-print'></i></button>";
        break;
    case 3:
        break;
}

$connect->_query = "
SELECT a.idcompra,c.nombre_proveedor,d.nick_name,sum((a.precio_compra * a.cantidad))as PrecioCompra ,b.fecha_alta FROM detalle_compra as a 
left join compra as b 
on a.idcompra = b.idcompra 
left join proveedores as c 
on b.idproveedor = c.idproveedor 
left join perfil_usuarios as d 
on b.idusuario_alta = d.idusuario 
WHERE b.idestado = $idEstado
GROUP BY a.idcompra
";

$connect->get_result_query();

for($i=0;$i <count($connect->_rows);$i++){

    $idCompra = $connect->_rows[$i][0];
    //Agregar IVA

    //Mostrar Botones
    if($idEstado == 1){
        $Botones =
            "
            <button class='btn btn-sm btn-default' title='Imprimir' onclick='VerFacturaDeCompra(1,".$idCompra.")'><i class='fa fa-print'></i></button> 
            <button class='btn btn-sm btn-default' title='Editar' ><i class='fa fa-edit'></i></button> 
            <button class='btn btn-sm btn-success' title='Dar Entrada' onclick='AutorizarFacturaCompra(2,".$idCompra.")'><i class='fa fa-upload'></i></button> 
            <button class='btn btn-sm btn-danger' title='Cancelar' onclick='CancelarFacturaCompra(1,".$idCompra.")'><i class='fa fa-close'></i></button>
            ";
    }else{
        $Botones =
            "
            <button class='btn btn-sm btn-default' title='Imprimir' onclick='VerFacturaDeCompra(1,".$idCompra.")'><i class='fa fa-print'></i></button> 
            ";
    }

    $arreglo['data'][] = array(
        "idorden"=>$connect->_rows[$i][0],
        "FolioOrden"=>$connect->getFormatFolio($connect->_rows[$i][0],6),
        "proveedor"=>$connect->_rows[$i][1],
        "total"=>$connect->setFormatoMoneda($connect->_rows[$i][3],'pesos'),
        "fecha"=>$connect->_rows[$i][4],
        "usuario"=>$connect->_rows[$i][2],
        "funciones"=>$Botones
    );
}
echo json_encode($arreglo);