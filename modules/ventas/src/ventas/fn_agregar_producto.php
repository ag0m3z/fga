<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 30/05/2017
 * Time: 05:06 PM
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

include "../../controller/ClassControllerCarritoVentas.php";
/**
 * 1.- Instanciar la Clase seguridad y pasar como valor la BD del Usuario
 * 2.- Llamar al metodo @@valida_session_id($NoUsuario), para validar que el usuario este conectado y con una sesión valida
 *
 * Ejemplo:
 * Si se requiere cambiar de servidor de base de datos
 * $data_server = array(
 *   'bdHost'=>'192.168.2.5',
 *   'bdUser'=>'sa',
 *   'bdPass'=>'pasword',
 *   'port'=>'3306',
 *   'bdData'=>'dataBase'
 *);
 *
 * Si no es requerdio se puede dejar en null
 *
 * con @data_server
 * @@$seguridad = new \core\seguridad($_SESSION['data_login']['BDDatos'],$data_server);
 *
 * Sin @data_server
 * @@$seguridad = new \core\seguridad($_SESSION['data_login']['BDDatos']);
 *
 * @@$seguridad->valida_session_id($_SESSION['data_login']['NoUsuario']);
 */

$connect = new \core\seguridad();
$connect->valida_session_id();

$carrito = new ClassControllerCarritoVentas();

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);

$idEmpresa = $_SESSION['data_home']['idempresa'];
$idAlmacen = $_SESSION['data_home']['almacen'];
$_POST = $connect->get_sanatiza($_POST);

$idArticulo = $_POST['idproducto'];
$Descripcion = $_POST['descripcion'];

$Cantidad = $_POST['idcantidad'];
$TipoProducto  = $_POST['tipo_producto'];
$TipoDiseno = $_POST['TipoDiseno'];

$connect->_query = "
        select 
        b.idarticulo,
        b.nombre_articulo,
        b.codigo,
        b.precio_venta,
        b.precio_mayoreo,
        b.cantidad_mayoreo,
        ifnull(a.existencias,0)as existencias,
        ifnull(a.idalmacen,0),
        b.precio_compra
        FROM articulos as b 
        LEFT JOIN almacen_articulos as a
        ON b.idarticulo = a.idarticulo
        WHERE  b.idarticulo = $idArticulo AND b.idempresa = $idEmpresa;
        ";

$connect->get_result_query();
$data_producto2 = $connect->_rows;
$data_producto = array();
for($i=0;$i<count($data_producto2);$i++){

    if($data_producto2[$i][7] ==  $idAlmacen){
        $data_producto = $data_producto2[$i];
    }
}

if(count($data_producto)<=0){
    for($i=0;$i<count($data_producto2);$i++){

        if($data_producto2[$i][7] ==  0){
            $data_producto = $data_producto2[$i];
        }
    }
}

header("Content-type:application/json");

/**
 * if($Cantidad >= $data_producto[6]){
echo json_encode(array(
"result"=>"error",
"mensaje"=>"No cuenta con suficiente stock"
));
exit();
}
 */

$carrito->introduce_producto(
    $_POST['idproducto'],
    $TipoProducto,
    $_POST['nombre_producto'],
    $data_producto[3],
    $Cantidad,
    $Descripcion,
    $TipoDiseno,
    $data_producto[6],
    $data_producto[8]
);

echo json_encode(array(
    "result"=>true,
    "message"=>"Producto agregado",
    "data"=>array(
        "id"=>$_POST['idproducto'],
        "nombre"=>$_POST['nombre_producto'],
        "tipo"=>$TipoProducto,
        "costotrabajo"=>$TipoDiseno,
        "cantidad"=>$Cantidad,
        "existencias"=>$data_producto[6],
        "detalle"=>array(
            "product"=>$data_producto,
            "datapost"=>$_POST
        )
    ),
));