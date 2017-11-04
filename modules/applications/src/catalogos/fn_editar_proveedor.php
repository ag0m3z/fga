<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 16/04/2017
 * Time: 11:34 AM
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

if(array_key_exists('idproveedor',$_POST)||array_key_exists('nombre_proveeodr',$_POST)){

    //Sanatizar datos
    $NombreProveeodr = $proveedores->get_sanatiza($_POST['nombre_proveedor']);
    $DescripcionProveedor = $proveedores->get_sanatiza($_POST['descripcion_proveedor']);
    $Telefono01 = $proveedores->get_sanatiza($_POST['telefono1_proveedor']);
    $Telefono02 = $proveedores->get_sanatiza($_POST['telefono2_proveedor']);
    $Celular = $proveedores->get_sanatiza($_POST['celular_proveedor']);
    $Direccion = $proveedores->get_sanatiza($_POST['direccion_proveedor']);
    $Correo = $proveedores->get_sanatiza($_POST['correo_proveedor']);
    $Telefono01 = $proveedores->get_sanatiza($_POST['telefono1_proveedor']);

    $proveedores->edit_proveedor(array(
        "idempresa"=>$_SESSION['data_home']['idempresa'],
        "idproveedor"=>$_POST['idproveedor'],
        "nombre_proveedor"=>$NombreProveeodr,
        'descripcion_proveedor'=>$DescripcionProveedor,
        'telefono01'=>$Telefono01,
        'telefono02'=>$Telefono02,
        'celular'=>$Celular,
        'correo'=>$Correo,
        'direccion'=>$Direccion,
        "idestado"=>$_POST['idestado_proveedor'],
        "idusuario_um"=>$_SESSION['data_login']['idusuario']
    ));

   if($proveedores->_confirm){
       echo '<script>getMessage("Proveeodr editado correctamente");menu_catalogos(7,7);$("#modalbtnclose").click()</script>';
   }else{
       \core\core::MyAlert($proveedores->_message,"error");
   }

}else{
    \core\core::MyAlert("Error al editar el proveedor","alert");
}
