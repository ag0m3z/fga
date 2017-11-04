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
include "../../../../core/model_almacen.php";

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

$almacen = new \core\model_almacen();
$almacen->valida_session_id();

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);

if(array_key_exists('idalmacen',$_POST)||array_key_exists('nombre_almacen',$_POST)){

    //Sanatizar datos
    $NombreAlmacen = $almacen->get_sanatiza($_POST['nombre_almacen']);
    $DescripcionAlmacen = $almacen->get_sanatiza($_POST['descripcion_almacen']);

    $almacen->edit_almacen(array(
        "idempresa"=>$_SESSION['data_home']['idempresa'],
        "idalmacen"=>$_POST['idalmacen'],
        "opcion_traspaso"=>$_POST['opcion_traspasos'],
        "idestado"=>$_POST['idestado_almacen'],
        "nombre_almacen"=>$NombreAlmacen,
        "descripcion_almacen"=>$DescripcionAlmacen,
        "idusuario_um"=>$_SESSION['data_login']['idusuario']
    ));

   if($almacen->_confirm){
       echo '<script>getMessage("Almacén editado correctamente");menu_catalogos(6,6);$("#modalbtnclose").click()</script>';
   }else{
       \core\core::MyAlert($almacen->_message,"error");
   }

}else{
    \core\core::MyAlert("Error al editar el almacén","alert");
}
