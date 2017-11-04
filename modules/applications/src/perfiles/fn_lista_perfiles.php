<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 15/04/2017
 * Time: 02:27 PM
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

$perfiles = new ControllerPerfiles();
$perfiles->valida_session_id();


$lista_perfiles = $perfiles->get_list(1,$_SESSION['data_home']['idempresa']);

for($i=0; $i < count($lista_perfiles); $i++){

    $arreglo['data'][] = array(
        "funciones"=>'<span class="btn btn-xs btn-info" onclick="nuevo_perfil(3,'.$lista_perfiles[$i][1].')" ><i class="fa fa-edit"></i></span> <span class="btn btn-xs btn-warning"><i class="fa fa-trash"></i></span>',
        "idperfil"=>$perfiles->getFormatFolio($lista_perfiles[$i][1],4),
        "nombre"=>$lista_perfiles[$i][2],
        "descripcion"=>$lista_perfiles[$i][3],
        "fecha_alta"=>$lista_perfiles[$i][5],
        "idestado"=>$lista_perfiles[$i][6]
    );
}

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/

echo json_encode($arreglo);