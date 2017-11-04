<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 23/05/2017
 * Time: 04:45 PM
 */
/**
 * Incluir las Librerias Principales del Sistema
 * En el Siguiente Orden ruta de libreias: @@/SistemaIntegral/core/
 * 1.- core.php;
 * 2.- sesiones.php
 * 3.- seguridad.php o modelo ( ej: model_aparatos.php)
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";
include "../../../../core/seguridad.class.php";
include "../../controller/ControllerCartTraspasos.php";
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

$CarritoTraspasos = new ControllerCartTraspasos();

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);

$lista = $CarritoTraspasos->imprime_carrito();


header('Content-type: application/json; charset=utf-8');

$idempresa = IDEMPRESA ;
$opcion = $_GET['opc'];
$idestado = $_GET['idestado'];
$AlmacenOrigen =$lista[0]['idalmacen_origen'];
$AlmacenDestino = $_SESSION['cart_traspasos'][0]['idalmacen_destino'];
$UsuarioSolicita = $_SESSION['cart_traspasos'][0]['idusuario_solicita'];
$FechaActual = date("Y-m-d H:i:s");

$UsuarioRegistra = IDUSUARIO;
$UsuarioAutoriza = 0;

if($idestado == 2){ $UsuarioAutoriza = $UsuarioRegistra ;}


if(count($lista) > 0){

    $connect->_query = "INSERT INTO traspasos (
    idempresa,
    idalmacen_origen,
    idalmacen_destino,
    idestado,
    idusuario_solicita,
    idusuario_registra,
    idusuario_autoriza,
    fecha_alta,
    idusuario_alta,
    fecha_um,
    idusuario_um
    ) VALUES (
    '$idempresa',
    '$AlmacenOrigen',
    '$AlmacenDestino',
    '$idestado',
    '$UsuarioSolicita',
    '$UsuarioRegistra',
    '$UsuarioAutoriza',
    '$FechaActual',
    '$UsuarioRegistra',
    '$FechaActual',
    '$UsuarioRegistra'
    )";

    $connect->execute_query();

    $connect->_query = "SELECT @@identity AS id";
    $connect->get_result_query();
    $idTraspaso = $connect->_rows[0][0];

    for($i=0;$i < count($lista); $i++){

        $TipoArticulo = $lista[$i]['tipo'];
        $IDArticulo = $lista[$i]['idarticulo'];
        $Cantidad = $lista[$i]['cantidad'];

        $connect->_query = "CALL sp_registra_detalle_traspaso(
        '1',
        '$idempresa',
        '$idTraspaso',
        '$idestado',
        '$UsuarioAutoriza',
        '$AlmacenOrigen',
        '$AlmacenDestino',
        '$TipoArticulo',
        '$IDArticulo',
        '$Cantidad'
        )";

        $connect->get_result_query();
    }

    echo json_encode(
        array(
            "result"=>"ok",
            "mensaje"=>"Registrado Correctamente",
            "id"=>$idTraspaso,
            "total"=>count($lista)
        )
    );

}else{

    echo json_encode(array(
        "result"=>"error",
        "mensaje"=>"No hay productos para realizar el traspaso"
    ));
}


