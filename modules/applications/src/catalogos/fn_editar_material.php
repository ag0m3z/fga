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
include "../../../../core/model_materiales.php";

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
$connect = new \core\model_materiales();
$connect->valida_session_id();
/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/

if(array_key_exists('nombre_material',$_POST) && array_key_exists('idmaterial',$_POST) && array_key_exists('descripcion_material',$_POST) ){

    //Sanatizacion de Datos
    $IDMaterial = $_POST['idmaterial'];
    $idEmpresa = $_SESSION['data_home']['idempresa'];
    $NombreMaterial = $connect->get_sanatiza($_POST['nombre_material']);
    $Descripcion = $connect->get_sanatiza($_POST['nombre_material']);
    $idColor = $_POST['idcolor'];
    $TipoUnidad = $_POST['tipo_unidad'];
    $PrecioCompra = $_POST['precio_compra'];
    $PrecioVenta = $_POST['precio_venta'];
    $StockMinimo = $_POST['stock_minimo'];
    $StockMaximo = $_POST['stock_maximo'];
    $idestado = 1;
    $UsuarioAlta = $_SESSION['data_login']['idusuario'];
    $FechaAlta = date("Y-m-d H:i:s");


    $connect->edit_materiales(array(
        'idmaterial'=>$IDMaterial,
        'idempresa'=>$idEmpresa,
        'nombre_material'=>$NombreMaterial,
        'descripcion_material'=>$Descripcion,
        'idcolor'=>$idColor,
        'tipo_unidad'=>$TipoUnidad,
        'precio_compra'=>$PrecioCompra,
        'precio_venta'=>$PrecioVenta,
        'stock_minimo'=>$StockMinimo,
        'stock_maximo'=>$StockMaximo,
        'idestado'=>$idestado,
        'idusuario_alta'=>$UsuarioAlta,
        'fecha_alta'=>$FechaAlta
    ));

    if($connect->_confirm){
        header('Content-type: application/json; charset=utf-8');

        echo json_encode(array('confirm'=>'ok'));
        exit();
    }else{
        header('Content-type: application/json; charset=utf-8');
        echo json_encode(array('confirm'=>'false','mensaje'=>$connect->_message));
        exit();
    }

}else{
    header('Content-type: application/json; charset=utf-8');
    echo json_encode(array('confirm'=>'false','mensaje'=>'Error no se econtraron los parametros para la edicion'));
    exit();
}