<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 26/06/2017
 * Time: 01:42 PM
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
include "../../controllers/usuarios/ClassControllerUsuarios.php";

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

$connect = new ClassControllerUsuarios();
$connect->valida_session_id();

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);

header("ContentType:application/json");
if(
    array_key_exists('nombre',$_POST) &&
    array_key_exists('apaterno',$_POST) &&
    array_key_exists('amaterno',$_POST) &&
    array_key_exists('departamento',$_POST) &&
    array_key_exists('nickname',$_POST) &&
    array_key_exists('usuario_login',$_POST) &&
    array_key_exists('clave1',$_POST) &&
    array_key_exists('clave2',$_POST) &&
    array_key_exists('perfil',$_POST)

){

    //Sanatizar Datos
    //$_POST = $connect->get_sanatiza($_POST);


    $connect->set_usuario(array(
    'nombre'=>$connect->get_sanatiza($_POST['nombre']),
    'apaterno'=>$connect->get_sanatiza($_POST['apaterno']),
    'amaterno'=>$connect->get_sanatiza($_POST['amaterno']),
    'departamento'=>$_POST['departamento'],
    'idempresa'=>$_SESSION['data_home']['idempresa'],
    'perfil'=>$_POST['perfil'],
    'usuario_login'=>$connect->get_sanatiza($_POST['usuario_login']),
    'clave1'=>md5($_POST['clave1']),
    'clave2'=>md5($_POST['clave2']),
    'intentos'=>0,
    'idestado'=>1,
    'idusuario_alta'=>$_SESSION['data_login']['idusuario'],
    'fecha_alta'=>date("Y-m-d H:i:s"),
    'nickname'=>$connect->get_sanatiza($_POST['nickname']),
    'telefono'=>$connect->get_sanatiza($_POST['telefono']),
    'celular'=>$connect->get_sanatiza($_POST['celular'])
    ));



    $idUsuario = $connect->_message;

    if($idUsuario>=2){
        $array = json_decode($_POST['accesos']);
        for ($i = 0; $i < count($array); $i++) {

            $lista = $array[$i]->value;

            list(
                $idModulo, $sopcion
                ) = explode(
                "-", $lista
            );

            switch ($sopcion) {
                case "c":
                    $sopcion = "consultar";
                    break;
                case "a":
                    $sopcion = "agregar";
                    break;
                case "m":
                    $sopcion = "editar";
                    break;
                case "e":
                    $sopcion = "eliminar";
                    break;
            }

            $connect->_query = "
            UPDATE modulos_acceso SET $sopcion = 1 WHERE idmodulo = $idModulo AND idusuario = $idUsuario
            ";
            $connect->execute_query();

        }
    }


    if($connect->_confirm){
        echo json_encode(array("result"=>true,"message"=>$connect->_message,"data"=>$_POST,"nombre"=>$oppcion));

        //echo "<script>menu_catalogos(11,11);getMessage('Usuario registrado correctamente','Alta de usuario','success',2500)</script>";

    }else{
       echo json_encode(array("result"=>false,"message"=>$connect->_message,"data"=>$_POST,"nombre"=>$oppcion));
    }



}else{
    echo json_encode(array("result"=>false,"message"=>"No se encontraron datos para registrar"));
}