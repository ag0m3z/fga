<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 28/04/2017
 * Time: 02:55 PM
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
include "../../controllers/clientes/ClassControllerClientes.php";

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
$connect = new ClassControllerClientes();
$connect->valida_session_id();
/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);


if(array_key_exists('nombre_cliente',$_POST)){

    $NombreCliente = $connect->get_sanatiza($_POST['nombre_cliente']);
    $CorreoCliente = $connect->get_sanatiza($_POST['correo']);
    $Telefono = $connect->get_sanatiza($_POST['telefono']);
    $Celular = $connect->get_sanatiza($_POST['celular']);


    $connect->set_cliente(array(
       'nombre_cliente'=>$NombreCliente,
        'correo'=>$CorreoCliente,
        'telefono'=>$Telefono,
        'celular'=>$Celular,
        'idestado'=>1,
        'idempresa'=>$_SESSION['data_home']['idempresa'],
        'idusuario_alta'=>$_SESSION['data_login']['idusuario'],
        'fecha_alta'=>date("Y-m-d H:i:s")
    ));

    if($connect->_confirm){

        $connect->_query = "SELECT @@identity AS id";
        $connect->get_result_query();
        $idCliente = $connect->_rows[0][0];

        echo '<script>getMessage("Cliente registrado correctamente","","success",3000);menu_catalogos(9,9);$("#modalbtnclose").click()</script>';
        echo '<script>AddOptionSelect("#idcliente","'.$idCliente.'","'.$NombreCliente.'")</script>';

    }else{
        \core\core::MyAlert($connect->_message,"alert");
    }


}else{
    \core\core::MyAlert("No se encontraron los datos para registrar el cliente","alert");
}