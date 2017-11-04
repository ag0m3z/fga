<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 05/06/2017
 * Time: 06:39 PM
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

$connect = new \core\seguridad();
$connect->valida_session_id();
$idEmpresa = $_SESSION['data_home']['idempresa'];
$idDepartamento = $_SESSION['data_home']['iddepartamento'];
$NoUsuarioAlta = $_SESSION['data_login']['idusuario'];
header("Content-type:application/json");

if($_SERVER['REQUEST_METHOD'] == "GET"){

    if(array_key_exists('FechaActual',$_GET)){

        $DateTIME = date("Y-m-d H:i:s");

        $FechaApertura = $_GET['FechaActual'];
        $connect->_query = "SELECT count(idempresa) FROM apertura WHERE date(fecha_apertura) = '$FechaApertura' AND idempresa = $idEmpresa AND iddepartamento =  $idDepartamento ";
        $connect->get_result_query();
        $Total = $connect->_rows[0][0];

        if($Total > 0){
            echo json_encode(array("result"=>true,"message"=>"Apertura realizada correctamente","data"=>array()));
        }else{
            echo json_encode(array("result"=>false,"message"=>"La apertura ya esta realizada","data"=>array()));
        }

    }else{
        echo json_encode(array("result"=>false,"message"=>"No se encontraron los parametros para realizar la apertura","data"=>array()));
    }

}else{

    echo json_encode(array("result"=>false,"message"=>"Metodo no soportado","data"=>array()));
}