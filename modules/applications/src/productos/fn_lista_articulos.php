<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 03/05/2017
 * Time: 05:19 PM
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
include "../../../../core/model_articulos.php";

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
$articulos = new \core\model_articulos();
$articulos->valida_session_id();

/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/
unset($_SESSION['EXPORT']);

$lista_articulos = $articulos->get_list(1,$_SESSION['data_home']['idempresa']);

switch ($_POST['parametro']){
    case 1:
        for($i=0; $i < count($lista_articulos); $i++){

            $idarticulo = $lista_articulos[$i][3];
            $Botones ='<span class="btn btn-xs btn-info" onclick="nuevo_producto(3,'.$lista_articulos[$i][0].')" ><i class="fa fa-edit"></i></span> <span class="btn btn-xs btn-warning"><i class="fa fa-trash"></i></span>';

            $arreglo['data'][] = array(
                "funciones"=>$Botones,
                "idarticulo"=>$articulos->getFormatFolio($lista_articulos[$i][0],4),
                "nombre"=>$lista_articulos[$i][1],
                "nombre_categoria"=>$lista_articulos[$i][5],
                "nombre_subcategoria"=>$lista_articulos[$i][7],
                "talla"=>$lista_articulos[$i][9],
                "usuario_alta"=>$lista_articulos[$i][14],
                "fecha_alta"=>$lista_articulos[$i][15]
            );
        }
        break;
    case 2:
        for($i=0; $i < count($lista_articulos); $i++){

            $idarticulo = $lista_articulos[$i][3];
            $Botones = '<span class="btn btn-sm btn-info" onclick="nueva_orden_compra(3,'.$lista_articulos[$i][0].')" ><i class="fa fa-shopping-cart"></i></span>';

            $arreglo['data'][] = array(
                "funciones"=>$Botones,
                "idarticulo"=>$articulos->getFormatFolio($lista_articulos[$i][0],4),
                "nombre"=>$lista_articulos[$i][1],
                "cantidad"=>"<inpunt id='row-".$i."-cantidad' name='row-".$i."-cantidad' class='form-control' value='1' type='text' >",
                "precio"=>$lista_articulos[$i][7]
            );
        }

        break;
    default:
        for($i=0; $i < count($lista_articulos); $i++){

            $idarticulo = $lista_articulos[$i][3];
            $Botones ='<span class="btn btn-xs btn-info" onclick="nuevo_producto(3,'.$lista_articulos[$i][0].')" ><i class="fa fa-edit"></i></span> <span class="btn btn-xs btn-warning"><i class="fa fa-trash"></i></span>';

            $arreglo['data'][] = array(
                "funciones"=>$Botones,
                "idarticulo"=>$articulos->getFormatFolio($lista_articulos[$i][0],4),
                "nombre"=>$lista_articulos[$i][1],
                "nombre_categoria"=>$lista_articulos[$i][5],
                "nombre_subcategoria"=>$lista_articulos[$i][7],
                "talla"=>$lista_articulos[$i][9],
                "usuario_alta"=>$lista_articulos[$i][14],
                "fecha_alta"=>$lista_articulos[$i][15]
            );
        }
        break;
}
/**@@ Vacriar Variable el cual contiene los datos de la ultima exportacion de
 **   Cualquier reporte
 **/

echo json_encode($arreglo);