<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 08/06/2017
 * Time: 09:13 AM
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

include "../../controller/ControllerCartTraspasos.php";

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

$carrito = new ControllerCartTraspasos();

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);


header("Content-type:application/json");


if(!array_key_exists('idarticulo',$_POST)){
    echo json_encode(array("result"=>"error","mensaje"=>"No se encontro el id del articulo o material"));
}else{
    if(!isset($_POST['idarticulo'])){
        echo json_encode(array("result"=>"error","mensaje"=>"No se encontro el id del articulo o material"));
    }else{

        $carrito->elimina_producto($_POST['idarticulo']);
        echo json_encode(array("result"=>"ok"));
    }
}