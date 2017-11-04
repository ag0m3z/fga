<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 15/04/2017
 * Time: 03:48 PM
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
include "../../../../core/model_proveedores.php";

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

$proveedores = new \core\model_proveedores();
$proveedores->valida_session_id();

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);

if(array_key_exists('nombre_proveedor',$_POST) || array_key_exists('direccion_proveedor',$_POST)
    || array_key_exists('descripcion_proveedor',$_POST) ){

    //Sanatizar Datos
    $NombreProveedor = $proveedores->get_sanatiza($_POST['nombre_proveedor']);
    $CorreoProveedor = $proveedores->get_sanatiza($_POST['correo_proveedor']);
    $DireccionProveedor = $proveedores->get_sanatiza($_POST['direccion_proveedor']);
    $Telefono1 = $proveedores->get_sanatiza($_POST['telefono1_proveedor']);
    $Telefono2 = $proveedores->get_sanatiza($_POST['telefono2_proveedor']);
    $CelularProveedor = $proveedores->get_sanatiza($_POST['celular_proveedor']);
    $DescripcionProveedor = $proveedores->get_sanatiza($_POST['descripcion_proveedor']);

    $proveedores->set_proveedor(array(
        'idempresa'=>$_SESSION['data_home']['idempresa'],
        'nombre_proveedor'=>$NombreProveedor,
        'correo_proveedor'=>$CorreoProveedor,
        'direccion_proveedor'=>$DireccionProveedor,
        'descripcion_proveedor'=>$DescripcionProveedor,
        'telefono1_proveedor'=>$Telefono1,
        'telefono2_proveedor'=>$Telefono2,
        'telefono3_proveedor'=>"",
        'celular_proveedor'=>$CelularProveedor,
        'idestado'=>'1',
        'idusuario_alta'=>$_SESSION['data_login']['idusuario'],
        'fecha_alta'=>date("Y-m-d H:i:s")
    ));

    if($proveedores->_confirm){

        echo "<script>getMessage('Proveedor registrador correctamente');menu_catalogos(7,7);$('#modalbtnclose').click();</script>";

    }else{
        \core\core::MyAlert($proveedores->_message,"alert");
    }


}else{
    echo "error al recibir los parametros";
}