<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 06/09/2017
 * Time: 03:58 PM
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

header("ContentType:application/json");

$idEmpresa = $_POST['idempresa'];


if($_SESSION['data_login']['idperfil'] == 1){
    //Perfil de Administrador

    //Cantidad de Articulos en todos los almacenes
    $connect->_query = "SELECT ifnull(cast(sum(existencias) as SIGNED),0)as total FROM almacen_articulos where idempresa = $idEmpresa and tipo_articulo = 'ART' ";
    $connect->get_result_query();
    $TotalInventario = $connect->_rows[0][0];

    //Total de traspasos
    $connect->_query = "SELECT count(idtraspaso)as total FROM traspasos where idempresa = $idEmpresa";
    $connect->get_result_query();
    $TotalTraspaso = $connect->_rows[0][0];

    //Existencias Bajas
    $connect->_query = "SELECT b.nombre_articulo,a.tipo_articulo,CAST(a.existencias  AS SIGNED)as Existencias,c.nombre_almacen as Almacen
    FROM almacen_articulos as a 
    LEFT JOIN articulos as b 
    ON a.idarticulo = b.idarticulo AND a.tipo_articulo = 'ART'
    LEFT JOIN almacen as c  
    ON a.idalmacen = c.idalmacen
    where a.existencias < b.stock_minimo and a.idempresa = $idEmpresa";

    $connect->get_result_query(true);
    $ListaExistanciasBajas = $connect->_rows;
    $ExistenciasBajas = count($connect->_rows);

    //SinExistencias
    $connect->_query = "SELECT b.nombre_articulo,a.tipo_articulo,CAST(a.existencias  AS SIGNED)as Existencias  
    FROM almacen_articulos as a 
    LEFT JOIN articulos as b 
    ON a.idarticulo = b.idarticulo AND a.tipo_articulo = 'ART'
    where a.existencias <= 0 and a.idempresa = $idEmpresa";
    $connect->get_result_query(true);
    $ListaSinExistencias = $connect->_rows;
    $SinExistencias = count($connect->_rows);

    $Inventario = array(
        'Inventario'=>array(
            'titulo'=>"Inventario General",
            'total'=>$TotalInventario
        ),
        'Traspasos'=>array(
            'titulo'=>"Total Traspasos",
            'total'=>$TotalTraspaso
        ),
        'Existencias'=>array(
            'titulo'=>'Existencias Bajas',
            'total'=>$ExistenciasBajas
        ),
        'SinExistencias'=>array(
            'titulo'=>'Sin Existencias',
            'total'=>$SinExistencias
        )
    );

    //Ultimos 10 Traspasos
    $connect->_query = "
    SELECT LPAD(a.idtraspaso,6,'0')as FolioTraspaso,a.idtraspaso,b.nombre_almacen as almacen_origen,c.nombre_almacen as almacen_destino,a.idestado,date(a.fecha_alta)as fecha_alta,a.fecha_alta as FechaHora 
    FROM traspasos as a 
    left join almacen as b 
    on a.idalmacen_origen = b.idalmacen 
    left join almacen as c 
    on a.idalmacen_destino = c.idalmacen
    where a.idempresa = $idEmpresa and a.idestado >= 3 ORDER BY a.fecha_alta DESC limit 0,10 
    ";
    $connect->get_result_query(true);
    $ListaTraspasos = $connect->_rows;

    //Traaspasos por autrizar
    $connect->_query = "
    SELECT LPAD(a.idtraspaso,6,'0')as FolioTraspaso,a.idtraspaso,b.nombre_almacen as almacen_origen,c.nombre_almacen as almacen_destino,a.idestado,date(a.fecha_alta)as fecha_alta,a.fecha_alta as FechaHora 
    FROM traspasos as a 
    left join almacen as b 
    on a.idalmacen_origen = b.idalmacen 
    left join almacen as c 
    on a.idalmacen_destino = c.idalmacen
    where a.idempresa = $idEmpresa and a.idestado = 1 ORDER BY a.fecha_alta DESC limit 0,10 
    ";
    $connect->get_result_query(true);
    $TraspasosPorAutorizar = $connect->_rows;

    //Traaspasos por Confirmar y En Transito
    $connect->_query = "
    SELECT LPAD(a.idtraspaso,6,'0')as FolioTraspaso,a.idtraspaso,b.nombre_almacen as almacen_origen,c.nombre_almacen as almacen_destino,a.idestado,date(a.fecha_alta)as fecha_alta,a.fecha_alta as FechaHora 
    FROM traspasos as a 
    left join almacen as b 
    on a.idalmacen_origen = b.idalmacen 
    left join almacen as c 
    on a.idalmacen_destino = c.idalmacen
    where a.idempresa = $idEmpresa and a.idestado = 2 ORDER BY a.fecha_alta DESC limit 0,10 
    ";
    $connect->get_result_query(true);
    $TraspasosPorConfirmar = $connect->_rows;


    $dataList = array(
        'sinExistencias'=>$ListaSinExistencias,
        'existenciasBajas'=>$ListaExistanciasBajas,
        'traspasos'=>$ListaTraspasos,
        'autorizar'=>$TraspasosPorAutorizar,
        'confirmar'=>$TraspasosPorConfirmar
    );


}else{
    //Perfil de Usuario

}


echo json_encode(
    array(
        "result"=>true,
        "message"=>"Prueba Exitosa",
        "data"=>array(
            'indicadores'=>$Inventario,
            'datalist'=>$dataList,
        )
    )
);