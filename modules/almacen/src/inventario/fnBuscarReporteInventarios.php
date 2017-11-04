<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 29/09/2017
 * Time: 01:25 AM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";

$connect = new \core\seguridad();
$NoUsuario = $_SESSION['data_login']['idusuario'];
$idEmpresa = $_SESSION['data_home']['idempresa'];

header("ContentType:application/json");


if($_SERVER['REQUEST_METHOD'] == "GET"){

    $_GET = $connect->get_sanatiza($_GET);

    $arrayData = array(
        "a.idarticulo"=>$_GET['idarticulo'],
        "a.idalmacen"=>$_GET['idalmacen'],
        "c.idcategoria"=>$_GET['idcategoria'],
        "a.tipo_articulo"=>$_GET['idTipo']
    );

    foreach($arrayData as $id=>$valor){

        if($valor != "0"){

            if($id == "a.tipo_articulo"){

                if($valor == 1){$valor = "ART";}else{$valor = "MAT";}

            }

            $valor = "'$valor'";
            $Cond[] = array($id,$valor);

        }
    }

    $size = count($Cond);

    if($size >0){
        $w = " WHERE ";
    }else{
        $w = "";
    }

    for($i=0;$i <= $size;$i++){
        if($size > $i){
            $and = " and ";
        }else{
            $and="";
        }
        $where[] = $Cond[$i][0]."=".$Cond[$i][1].$and;
    }

    $cadena = $w . substr($where[0].$where[1].$where[2].$where[3].$where[4].$where[5].$where[6].$where[7].$where[8],0,-5);

    $connect->_query = "SELECT a.idempresa,a.idalmacen,b.nombre_almacen,a.idarticulo,c.nombre_articulo,a.tipo_articulo,a.existencias,c.idcategoria,d.nombre_catalogo 
	FROM almacen_articulos as a 
	LEFT JOIN almacen as b 
	ON a.idalmacen = b.idalmacen 
	LEFT JOIN articulos as c 
	ON a.idarticulo = c.idarticulo
    LEFT JOIN catalogo_general as d 
	ON c.idcategoria = d.opc_catalogo and d.idcatalogo = 1 
	$cadena
    ";
    $connect->get_result_query(true);

    $_SESSION['EXPORT'] = $connect->_rows;

    echo json_encode(array("result"=>true,"message"=>"Consulta exitosa","data"=>$connect->_rows));

}else{
    echo json_encode(array("result"=>false,"message"=>"Metodo no soportado"));
}