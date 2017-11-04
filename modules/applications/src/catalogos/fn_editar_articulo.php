<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 25/04/2017
 * Time: 04:20 PM
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
include "../../../../core/model_articulos.php";

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
$connect = new \core\model_articulos();
$connect->valida_session_id();
/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/

if(
    array_key_exists('idarticulo',$_POST) &&
    array_key_exists('nombre_producto',$_POST) &&
    array_key_exists('descripcion',$_POST) &&
    array_key_exists('codigo',$_POST) &&
    array_key_exists('idcategoria',$_POST) &&
    array_key_exists('idsubcategoria',$_POST) &&
    array_key_exists('idtalla',$_POST) &&
    array_key_exists('idcolor',$_POST) &&
    array_key_exists('precio_venta',$_POST) &&
    array_key_exists('precio_compra',$_POST) &&
    array_key_exists('stock_minimo',$_POST)
){

    //Sanatizacion de Datos
    $idArticulo = $_POST['idarticulo'];
    $idEmpresa = $_SESSION['data_home']['idempresa'];
    $CodigoProducto = $connect->get_sanatiza($_POST['codigo']);
    $NombreProducto = $connect->get_sanatiza($_POST['nombre_producto']);
    $Descripcion = $connect->get_sanatiza($_POST['descripcion']);

    $idCategoria = $_POST['idcategoria'];
    $idSubcategoria = $_POST['idsubcategoria'];
    $idTalla = $_POST['idtalla'];
    $idColor = $_POST['idcolor'];
    $TipoUnidad = 1;

    $PrecioCompra = $_POST['precio_compra'];
    $PrecioVenta = $_POST['precio_venta'];
    $PrecioMayoreo = $_POST['precio_mayoreo'];
    $CantidadMayoreo = $_POST['cantidad_mayoreo'];

    $StockMinimo = $_POST['stock_minimo'];
    $StockMaximo = $_POST['stock_maximo'];
    $StockInicial = 0;

    $idestado = 1;
    $UsuarioAlta = $_SESSION['data_login']['idusuario'];
    $FechaAlta = date("Y-m-d H:i:s");

    $connect->edit_articulos(
        array(
            'idarticulo'=>$idArticulo,
            'codigo'=>$CodigoProducto,
            'nombre_producto'=>$NombreProducto,
            'descripcion'=>$Descripcion,
            'idcategoria'=>$idCategoria,
            'idsubcategoria'=>$idSubcategoria,
            'idtalla'=>$idTalla,
            'idcolor'=>$idColor,
            'precio_venta'=>$PrecioVenta,
            'precio_compra'=>$PrecioCompra,
            'precio_mayoreo'=>$PrecioMayoreo,
            'cantidad_mayoreo'=>$CantidadMayoreo,
            'stock_minimo'=>$StockMinimo,
            'stock_maximo'=>$StockMaximo,
            'stock_inicial'=>$StockInicial,
            'idestado'=>$idestado,
            'idusuario_alta'=>$UsuarioAlta,
            'fecha_alta'=>$FechaAlta,
            'unidad_medida'=>$TipoUnidad,
            'idempresa'=>$idEmpresa
        )
    );



   if($connect->_confirm){

       echo "<script>menu_catalogos(1,1)</script>";
       //echo json_encode(array('confirm'=>'ok'));
        exit();
    }else{
       \core\core::MyAlert($connect->_message,"alert");
        //echo json_encode(array('confirm'=>'false','mensaje'=>$connect->_message));
        exit();
    }
}else{
        \core\core::MyAlert('Error no se encontraron los datos para el registro','alert');
    //echo json_encode(array('confirm'=>'false','mensaje'=>'Error no se encontraron los datos para el registro'));
    exit();
}