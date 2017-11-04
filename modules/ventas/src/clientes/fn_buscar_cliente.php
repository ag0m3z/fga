<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 09/06/2017
 * Time: 06:05 PM
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

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);

//"itemName":"Test item no. 1","id":5


$connect = new \core\seguridad();
$connect->valida_session_id();

$TextSearch  =$_GET['term'];

$connect->_query = "SELECT idcliente,nombre_completo FROM clientes WHERE idcliente = '$TextSearch' OR nombre_completo like '%$TextSearch%' AND idestado = 1 ";
$connect->get_result_query();

$lista = $connect->_rows;

for($i=0;$i < count($connect->_rows);$i++){

    $data[] = array(
      "tag_value"=>$lista[$i][1],"tag_id"=>$lista[$i][0]
    );

}
echo json_encode($data);