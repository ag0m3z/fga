<?php
/**
 * Created by PhpStorm.
 * User: USUARIO
 * Date: 29/05/2017
 * Time: 09:08 PM
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
unset($_SESSION['EXPORT']);
$connect = new \core\seguridad();


//Datos de la empresa
$idAlmacen = $_SESSION['data_home']['almacen'];
$idPerfil = $_SESSION['data_login']['idperfil'];


if ($idPerfil == 1){
    //Perfil de administrador
    $connect->_query = "
    SELECT b.nombre_articulo,a.tipo_articulo,a.existencias 
    FROM almacen_articulos as a 
    LEFT JOIN articulos as b 
    ON a.idarticulo = b.idarticulo AND a.tipo_articulo = 'ART'
    where a.existencias < b.stock_minimo union 
    SELECT d.nombre_material,c.tipo_articulo,c.existencias 
    FROM almacen_articulos as c 
    LEFT JOIN materiales as d 
    ON c.idarticulo = d.idmateriales AND c.tipo_articulo = 'MAT' 
    WHERE c.existencias < d.stock_minimo
    ";
}else{
    //Perfil de usuario normal
    $connect->_query = "
    SELECT b.nombre_articulo,a.tipo_articulo,a.existencias 
    FROM almacen_articulos as a 
    LEFT JOIN articulos as b 
    ON a.idarticulo = b.idarticulo AND a.tipo_articulo = 'ART'
    where a.idalmacen = $idAlmacen AND a.existencias < b.stock_minimo union 
    SELECT d.nombre_material,c.tipo_articulo,c.existencias 
    FROM almacen_articulos as c 
    LEFT JOIN materiales as d 
    ON c.idarticulo = d.idmateriales AND c.tipo_articulo = 'MAT' 
    WHERE c.idalmacen = $idAlmacen AND c.existencias < d.stock_minimo
    ";
}

$connect->get_result_query();
$lista_bells = $connect->_rows;
$total = count($lista_bells);


echo json_encode(array(
   "result"=>"ok",
    "total"=>$total,
    "lista"=>$lista_bells
));




