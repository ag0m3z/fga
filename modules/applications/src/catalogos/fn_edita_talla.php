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
include "../../../../core/model_tallas.php";

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

$tallas = new \core\model_tallas();
$tallas->valida_session_id();

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);

if(array_key_exists('idtalla',$_POST)||array_key_exists('nombre_talla',$_POST)){

    //Sanatizar datos
    $NombreCategoria = $tallas->get_sanatiza($_POST['nombre_talla']);
    $DescripcionCategoria = $tallas->get_sanatiza($_POST['descripcion_talla']);

    $tallas->edit_talla(array(
        "idempresa"=>$_SESSION['data_home']['idempresa'],
        "idtalla"=>$_POST['idtalla'],
        "idestado"=>$_POST['idestado_talla'],
        "nombre_talla"=>$NombreCategoria,
        "descripcion_talla"=>$DescripcionCategoria,
        "idusuario_um"=>$_SESSION['data_login']['idusuario']
    ));

   if($tallas->_confirm){
       echo '<script>getMessage("Talla editada correctamente");menu_catalogos(4,4);$("#modalbtnclose").click()</script>';
   }else{
       \core\core::MyAlert($tallas->_message,"error");
   }


}else{
    \core\core::MyAlert("Error al editar la talla","alert");
}
