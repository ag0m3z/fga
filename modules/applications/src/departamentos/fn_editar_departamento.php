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
include "../../controllers/departamentos/ControllerDepartamentos.php";

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

$departamentos = new ControllerDepartamentos();
$departamentos->valida_session_id();

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);

if(
    array_key_exists('iddepartamento',$_POST) &&
    array_key_exists('nombre_departamento',$_POST) &&
    array_key_exists('idalmacen',$_POST) &&
    array_key_exists('total_cajas',$_POST) &&
    array_key_exists('domicilio',$_POST)
){

    //Sanatizacion de dats
    $NombreDepartamento = $departamentos->get_sanatiza($_POST['nombre_departamento']);
    $Domicilio = $departamentos->get_sanatiza($_POST['domicilio']);
    $Correo = $departamentos->get_sanatiza($_POST['correo']);
    $Telefono01 = $departamentos->get_sanatiza($_POST['telefono01']);
    $Telefono02 = $departamentos->get_sanatiza($_POST['telefono02']);
    $Celular = $departamentos->get_sanatiza($_POST['celular']);
    $HorarioSemanal = $departamentos->get_sanatiza($_POST['horario_semanal']);
    $HorarioFindeSemana = $departamentos->get_sanatiza($_POST['horario_findesemana']);

    $departamentos->edit_departamentos(array(
        'iddepartamento'=>$_POST['iddepartamento'],
        'idempresa'=>$_SESSION['data_home']['idempresa'],
        'nombre_departamento'=>$NombreDepartamento,
        'idalmacen'=>$_POST['idalmacen'],
        'total_cajas'=>$_POST['total_cajas'],
        'domicilio'=>$Domicilio,
        'telefono01'=>$Telefono01,
        'telefono02'=>$Telefono02,
        'celular'=>$Celular,
        'correo'=>$Correo,
        'horario_semanal'=>$HorarioSemanal,
        'horario_findesemana'=>$HorarioFindeSemana,
        'idestado'=>$_POST['idestado'],
        'idusuario_alta'=>$_SESSION['data_login']['idusuario'],
        'fecha_alta'=>date("Y-m-d H:i:s")
    ));

    if($departamentos->_confirm){

        header('Content-type: application/json; charset=utf-8');
        echo $res = json_encode(array('confirm'=>'ok','mensaje'=>'Departamento editado correctamente'));
    }else{
        header('Content-type: application/json; charset=utf-8');
        echo $res = json_encode(array('confirm'=>'false','mensaje'=>$departamentos->_message));
    }

}else{
    header('Content-type: application/json; charset=utf-8');
    echo $res = json_encode(array('confirm'=>'false','mensaje'=>'no se encontraron los parametros'));
}