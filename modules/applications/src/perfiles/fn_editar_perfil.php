<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 29/04/2017
 * Time: 09:58 AM
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
include "../../controllers/perfiles/ControllerPerfiles.php";

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

$connect = new ControllerPerfiles();
$connect->valida_session_id();

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);

if(array_key_exists('nombre_perfil',$_POST) && array_key_exists('idperfil',$_POST)){

    //Sanatizar Datos
    $NombrePerfil = $connect->get_sanatiza($_POST['nombre_perfil']);
    $Descripcion = $connect->get_sanatiza($_POST['descripcion']);
    $idempresa = $_SESSION['data_home']['idempresa'];
    $idestado = 1;
    $idperfil = $_POST['idperfil'];
    $FechaAlta = date("Y-m-d H:i:s");
    $idusuario_alta = $_SESSION['data_login']['idusuario'];

    $connect->edit_perfil(array(
        'idperfil'=>$idperfil,
        'nombre_perfil'=>$NombrePerfil,
        'descripcion'=>$Descripcion,
        'idempresa'=>$idempresa,
        'idestado'=>$idestado,
        'fecha_um'=>$FechaAlta,
        'idusuario_um'=>$idusuario_alta
    ));

    if($connect->_confirm){

        echo "<script>getMessage('Se edito el perfil correctamente');menu_catalogos(12,12);$('#modalbtnclose').click();</script>";

    }else{
        \core\core::MyAlert($connect->_message,"alert");
    }


}else{
    \core\core::MyAlert("Ingrese el nombre del pefil","alert");
}