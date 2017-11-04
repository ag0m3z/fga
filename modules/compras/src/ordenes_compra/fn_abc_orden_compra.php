<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 03/05/2017
 * Time: 01:48 PM
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

include "../../controllers/ControllerCart.php";

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
$_SESSION['cart'];
$data = new ControllerCart();
$idEmpresa = $_SESSION['data_home']['idempresa'];
$idUsuario = $_SESSION['data_login']['idusuario'];
$FechaAlta = date("Y-m-d H:i:s");
$opc = $_POST['parametro'];

$id_producto = 3;
$nombre_producto = "Camisas Talla GDN";
$cantidad_producto = 3;
$precio_producto = 90.00;

switch ($opc){
    case 1:
        header('Content-type: application/json; charset=utf-8');
        //Crear Orden de Compra desde una venta con inventario Negativo
        $idDepartamento = $_SESSION['data_home']['almacen'];
        $idProveedor = 1;

        $lista_producto = $_POST['lista_articulos'];

        if(count($lista_producto) > 0){

            $connect->_query = "call sp_registra_orden(
                '1',
                '0',
                '$idEmpresa',
                '$idDepartamento',
                '$idProveedor',
                '1',
                '0',
                '0',
                '$idUsuario',
                '$FechaAlta'
                )";
            $connect->get_result_query();

            $idCompra = $connect->_rows[0][0];


            for($i =0;$i < count($lista_producto);$i++){

                $idProducto = $lista_producto[$i]['idproducto'];
                $tipo_producto = $lista_producto[$i]['tipo_producto'];
                $Cantidad = $lista_producto[$i]['cantidad'];
                $Precio = $lista_producto[$i]['precio_compra'];
                $PrecioVenta = $lista_producto[$i]['precio_venta'];


                if($lista_producto[$i]['existencias'] <= 0){

                    $ExistReal = ($Cantidad + $lista_producto[$i]['existencias']);
                    $Cantidad = ($Cantidad - $ExistReal);


                    $connect->_query = "call sp_registra_detalle_compra(
                    '$idEmpresa',
                    '$idCompra',
                    '$tipo_producto',
                    '$idProducto',
                    '$Cantidad',
                    '$Precio',
                    '$PrecioVenta'
                    )";

                    $connect->execute_query();
                }

            }

            echo json_encode(array("result"=>true,"message"=>" Compra realizada correctamente ","data"=>array("idcompra"=>$idCompra)));

        }else{
            //Error al registrar la compra
            echo json_encode(array("result"=>false,"message"=>"Error no se encontro el id de la compra "));
        }



        break;
    case 2:

        //Eliminar producto

        $data->elimina_producto(2);
        var_dump($_SESSION['cart']);
        break;
    case 3:
        header('Content-type: application/json; charset=utf-8');
        echo $data->imprime_carrito();
        break;
    case 4:
        //Registrar Producto
        header('Content-type: application/json; charset=utf-8');
        if(count($_SESSION['cart']) > 0){



            $lista_producto = $data->imprime_carrito();

            if(count($lista_producto) > 0){

                $idProveedor = $_POST['idproveedor'];
                $idDepartamento = $_POST['iddepartamento'];

                $connect->_query = "call sp_registra_orden(
                '1',
                '0',
                '$idEmpresa',
                '$idDepartamento',
                '$idProveedor',
                '1',
                '0',
                '0',
                '$idUsuario',
                '$FechaAlta'
                )";
                    $connect->get_result_query();

                    $idCompra = $connect->_rows[0][0];


                for($i =0;$i < count($lista_producto);$i++){

                    $idProducto = $lista_producto[$i]['idarticulo'];
                    $tipo_producto = $lista_producto[$i]['tipo_producto'];
                    $Cantidad = $lista_producto[$i]['cantidad'];
                    $Precio = $lista_producto[$i]['precio_compra'];
                    $PrecioVenta = $lista_producto[$i]['precio_venta'];


                    $connect->_query = "call sp_registra_detalle_compra(
                    '$idEmpresa',
                    '$idCompra',
                    '$tipo_producto',
                    '$idProducto',
                    '$Cantidad',
                    '$Precio',
                    '$PrecioVenta'
                    )";

                    $connect->execute_query();

                }

                echo json_encode(array("confirm"=>"ok","mensaje"=>" Compra realizada correctamente ","data"=>array("idcompra"=>$idCompra)));

            }else{
                //Error al registrar la compra
                echo json_encode(array("confirm"=>"false","error"=>"Error no se encontro el id de la compra "));
            }

        }else{
            echo json_encode(array("confirm"=>"false","error"=>"Error no hay productos en la lista"));
        }
        break;
    default:
        header('Content-type: application/json; charset=utf-8');
        echo json_encode(array("confirm"=>"false","error"=>"Error no se encontro la opcion solicitada"));
        break;
}

