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
include "../../controllers/clientes/ClassControllerClientes.php";

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

$clientes = new ClassControllerClientes();
$clientes->valida_session_id();


$lista_clientes = $clientes->get_list($_POST['opc'],$_SESSION['data_home']['idempresa']);


for($i=0; $i < count($lista_clientes); $i++){

    $arreglo['data'][] = array(
        "funciones"=>'<span class="btn btn-xs btn-info" onclick="editar_cliente(1,'.$lista_clientes[$i][0].')" ><i class="fa fa-edit"></i></span> <span class="btn btn-xs btn-warning"><i class="fa fa-trash"></i></span>',
        "idcliente"=>$clientes->getFormatFolio($lista_clientes[$i][0],4),
        "nombre_cliente"=>$lista_clientes[$i][1],
        "telefono"=>$lista_clientes[$i][2],
        "celular"=>$lista_clientes[$i][3],
        "correo"=>$lista_clientes[$i][4],
        "fecha_alta"=>$lista_clientes[$i][9],
        "idestado"=>$lista_clientes[$i][11]
    );
}

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/

echo json_encode($arreglo);
