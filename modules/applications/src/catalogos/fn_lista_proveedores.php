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
include "../../../../core/model_proveedores.php";

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

$proveedores = new \core\model_proveedores();
$proveedores->valida_session_id();


$lista_proveedores = $proveedores->get_lista_proveedores(1,$_SESSION['data_home']['idempresa']);

for($i=0; $i < count($lista_proveedores); $i++){

    $arreglo['data'][] = array(
        "funciones"=>'<span class="btn btn-xs btn-info" onclick="editar_proveedor(1,'.$lista_proveedores[$i][0].')" ><i class="fa fa-edit"></i></span> <span class="btn btn-xs btn-warning"><i class="fa fa-trash"></i></span>',
        "idproveedor"=>$proveedores->getFormatFolio($lista_proveedores[$i][0],4),
        "nombre"=>$lista_proveedores[$i][2],
        "descripcion"=>$lista_proveedores[$i][3],
        "telefono1"=>$lista_proveedores[$i][4],
        "telefono2"=>$lista_proveedores[$i][5],
        "celular"=>$lista_proveedores[$i][7],
        "correo"=>$lista_proveedores[$i][6],
        "direccion"=>$lista_proveedores[$i][5],
        "fecha_alta"=>$lista_proveedores[$i][9],
        "idestado"=>$lista_proveedores[$i][9]
    );
}

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/

echo json_encode($arreglo);