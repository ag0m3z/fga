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
include "../../../../core/model_almacen.php";

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

$Almacenes = new \core\model_almacen();
$Almacenes->valida_session_id();


$lista_almacenes = $Almacenes->get_lista_almacenes(1,$_SESSION['data_home']['idempresa']);

for($i=0; $i < count($lista_almacenes); $i++){

    $traspasos = "Deshabilitado";
    if($lista_almacenes[$i][4] == 1){$traspasos ="Habilitado";}

    $arreglo['data'][] = array(
        "funciones"=>'<span class="btn btn-xs btn-info" onclick="editar_almacen(1,'.$lista_almacenes[$i][0].')" ><i class="fa fa-edit"></i></span> <span class="btn btn-xs btn-warning"><i class="fa fa-trash"></i></span>',
        "idalmacen"=>$Almacenes->getFormatFolio($lista_almacenes[$i][0],4),
        "nombre_almacen"=>$lista_almacenes[$i][2],
        "descripcion"=>$lista_almacenes[$i][3],
        "traspasos"=>$traspasos,
        "fecha_alta"=>$lista_almacenes[$i][7],
        "fecha_um"=>$lista_almacenes[$i][5],
        "idestado"=>$lista_almacenes[$i][6],
    );
}

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/

echo json_encode($arreglo);