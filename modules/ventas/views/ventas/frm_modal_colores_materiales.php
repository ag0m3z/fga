<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 29/05/2017
 * Time: 12:30 PM
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
include "../../../../core/model_categorias.php";
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


$connect = new \core\model_categorias();
$connect->valida_session_id();

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);

$idEmpresa = $_SESSION['data_home']['idempresa'];
$idAlmacen = $_SESSION['data_home']['almacen'];
$NombreMaterial = $_POST['textSearch'];

$connect->_query = "
SELECT b.idarticulo,b.nombre_articulo,c.nombre_catalogo as ColorMaterial,ifnull(a.idalmacen,0),ifnull(a.existencias ,0) 
FROM articulos as b
LEFT JOIN almacen_articulos as a
ON b.idarticulo = a.idarticulo 
LEFT JOIN catalogo_general as c
ON b.idcolor = c.opc_catalogo AND c.idcatalogo = 4
WHERE b.idempresa = $idEmpresa and b.tipo = 2 AND b.nombre_articulo LIKE '%$NombreMaterial%' ORDER BY a.existencias DESC
";
$connect->get_result_query();
$lista = $connect->_rows;


if(count($lista) > 0 ){
    echo "<div class='col-md-12' style='margin-top: -19px;' ><h4>Seleccione el Color del Material</h4></div>";

    for($i=0; $i < count($lista);$i++){
        $ColorMaterial = $lista[$i][2];
        $valor = $lista[$i][0]."-".$lista[$i][1];
        $nombre_articulo = $lista[$i][1];

        if($lista[$i][3] == $idAlmacen || $lista[$i][3] == 0){
            echo "<div class='col-md-4'><button style='background: ".$ColorMaterial."' onclick='getCrearTrabajo(4,{valor:\"".$valor."\",NombreProducto:\"".$nombre_articulo."\"})'  class='btn btn-app btn-block'>".$lista[$i][1]."</button></div>";

        }

    }
}else{
    echo "<div class='col-md-12 ' style='margin-top: -19px;'><h4 class='text-danger'>No se encontro el Material</h4></div>";
}