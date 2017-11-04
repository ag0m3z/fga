<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 04/09/2017
 * Time: 01:04 PM
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

$connect = new \core\seguridad();
$connect->valida_session_id();

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);

header("ContentType: applications/json");

$connect->_query = "SELECT a.idcompra,b.nombre_proveedor,a.fecha_alta FROM compra as a left join proveedores as b on a.idproveedor = b.idproveedor where a.idestado = 1";
$connect->get_result_query();

for($i=0;$i<count($connect->_rows);$i++){
    $data[] = array(
        "idcompra"=>$connect->_rows[$i][0],
        "FolioCompra"=>$connect->getFormatFolio($connect->_rows[$i][0],6),
        "nombre_proveedor"=>$connect->_rows[$i][1],
        "fecha_alta"=>$connect->_rows[$i][2]
    );
}

echo json_encode(array("result"=>true,"message"=>"Prueba Exitosa","data"=>$data));

