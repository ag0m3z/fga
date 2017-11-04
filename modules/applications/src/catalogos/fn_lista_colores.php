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
include "../../../../core/model_colores.php";

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

$color = new \core\model_colores();
$color->valida_session_id();


$lista_tallas = $color->get_lista_color(1,$_SESSION['data_home']['idempresa']);

for($i=0; $i < count($lista_tallas); $i++){

    $Codigocolor = $lista_tallas[$i][2];

    $arreglo['data'][] = array(
        "funciones"=>'<span class="btn btn-xs btn-info" onclick="editar_color(1,'.$lista_tallas[$i][0].')" ><i class="fa fa-edit"></i></span> <span class="btn btn-xs btn-warning"><i class="fa fa-trash"></i></span>',
        "idusuario"=>$color->getFormatFolio($lista_tallas[$i][0],4),
        "nombre"=>"<span class='badge' style='background: $Codigocolor;width: 130px;'>".$Codigocolor."</span>",
        "descripcion"=>$lista_tallas[$i][3],
        "fecha_alta"=>$lista_tallas[$i][4],
        "fecha_um"=>$lista_tallas[$i][5],
        "idestado"=>$lista_tallas[$i][6],
    );
}

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/

echo json_encode($arreglo);